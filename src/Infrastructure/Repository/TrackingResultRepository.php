<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\TrackingResult;
use App\Domain\Entity\TrackingCurrencyPair;
use App\Domain\Repository\TrackingResultRepositoryInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class TrackingResultRepository implements TrackingResultRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        $this->repository = $this->entityManager->getRepository(TrackingResult::class);
    }

    public function save(TrackingResult $trackingResult): void
    {
        $this->entityManager->persist($trackingResult);
        $this->entityManager->flush();
    }

    public function getLastByPair(TrackingCurrencyPair $trackingCurrencyPair): ?TrackingResult
    {
        return $this->repository->findOneBy([
            'trackingCurrencyPair' => $trackingCurrencyPair,
        ], ['id' => 'DESC']);
    }

    public function getTrackingResultInDateTime(TrackingCurrencyPair $pairInTargetDate, DateTime $targetDate): ?TrackingResult
    {
        return $this->repository->createQueryBuilder('t')
            ->where('t.trackingCurrencyPair = :pairInTargetDate')
            ->andWhere('t.createdAt <= :targetDate')
            ->setParameter('pairInTargetDate', $pairInTargetDate)
            ->setParameter('targetDate', $targetDate)
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
