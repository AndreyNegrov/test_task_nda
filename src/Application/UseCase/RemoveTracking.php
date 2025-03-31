<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Entity\TrackingCurrencyPair;
use App\Domain\Repository\TrackingCurrencyPairRepositoryInterface;
use App\Domain\UseCase\RemoveTrackingInterface;

readonly class RemoveTracking implements RemoveTrackingInterface
{
    public function __construct(
        private TrackingCurrencyPairRepositoryInterface $trackingSettingHistoryRepository
    ) {
    }

    public function process(string $baseCurrency, string $targetCurrency, ?string $error = null): void
    {
        $lastPairHistory = $this->trackingSettingHistoryRepository->getLastPair(
            $baseCurrency,
            $targetCurrency
        );

        if ($lastPairHistory !== null && $lastPairHistory->isTracked() === true) {
            $pair = new TrackingCurrencyPair(
                $baseCurrency,
                $targetCurrency,
                false,
                $error
            );

            $this->trackingSettingHistoryRepository->save($pair);
        }
    }
}
