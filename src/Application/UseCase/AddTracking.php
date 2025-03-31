<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Entity\TrackingCurrencyPair;
use App\Domain\Repository\TrackingCurrencyPairRepositoryInterface;
use App\Domain\UseCase\AddTrackingInterface;

readonly class AddTracking implements AddTrackingInterface
{
    public function __construct(
        private TrackingCurrencyPairRepositoryInterface $trackingSettingHistoryRepository
    ) {
    }

    public function process(string $baseCurrency, string $targetCurrency): void
    {
        $lastPairHistory = $this->trackingSettingHistoryRepository->getLastPair(
            $baseCurrency,
            $targetCurrency
        );

        if ($lastPairHistory !== null && $lastPairHistory->isTracked() === true) {
            return;
        }

        $pair = new TrackingCurrencyPair(
            $baseCurrency,
            $targetCurrency,
            true
        );

        $this->trackingSettingHistoryRepository->save($pair);
    }
}
