<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\TrackingCurrencyPair;
use App\Domain\Repository\TrackingCurrencyPairRepositoryInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

readonly class TrackingCurrencyPairRepository implements TrackingCurrencyPairRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        $this->repository = $this->entityManager->getRepository(TrackingCurrencyPair::class);
    }

    public function save(TrackingCurrencyPair $trackingCurrencyPair): void
    {
        $this->entityManager->persist($trackingCurrencyPair);
        $this->entityManager->flush();
    }

    public function getLastPair(string $baseCurrency, string $targetCurrency): ?TrackingCurrencyPair
    {
        return $this->repository->findOneBy([
            'baseCurrency' => $baseCurrency,
            'targetCurrency' => $targetCurrency,
        ], ['id' => 'DESC']);
    }

    public function getAllIsTracked(): array
    {
        $subQuery = $this->repository->createQueryBuilder('t2')
            ->select('MAX(t2.id)')
            ->groupBy('t2.baseCurrency, t2.targetCurrency');

        $query = $this->repository->createQueryBuilder('t')
            ->andWhere('t.id IN (' . $subQuery->getDQL() . ')')
            ->andWhere('t.isTracked = true')
            ->getQuery();

        return $query->getResult() ?? [];
    }

    public function getTrackingPairInDateTime(string $baseCurrency, string $targetCurrency, DateTime $targetDate): ?TrackingCurrencyPair
    {
        return $this->repository->createQueryBuilder('t')
            ->where('t.baseCurrency = :baseCurrency')
            ->andWhere('t.targetCurrency = :targetCurrency')
            ->andWhere('t.createdAt <= :targetDate')
            ->setParameter('baseCurrency', $baseCurrency)
            ->setParameter('targetCurrency', $targetCurrency)
            ->setParameter('targetDate', $targetDate)
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
