<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Exception\RateNotFoundException;
use App\Domain\Repository\TrackingCurrencyPairRepositoryInterface;
use App\Domain\Repository\TrackingResultRepositoryInterface;
use App\Domain\UseCase\GetRateInterface;
use DateTime;

class GetRate implements GetRateInterface
{
    public function __construct(
        private readonly TrackingCurrencyPairRepositoryInterface $trackingCurrencyPairRepository,
        private readonly TrackingResultRepositoryInterface $trackingResultRepository,
    ) {
    }

    public function process(string $baseCurrency, string $targetCurrency, DateTime $dateTime): float
    {
        $pairInTargetDate = $this->trackingCurrencyPairRepository->getTrackingPairInDateTime($baseCurrency, $targetCurrency, $dateTime);

        if ($pairInTargetDate === null || $pairInTargetDate->isTracked() === false) {
            throw new RateNotFoundException('В данный момент данная пара не отслеживалась');
        }

        $trackingResult = $this->trackingResultRepository->getTrackingResultInDateTime($pairInTargetDate, $dateTime);

        if ($trackingResult === null) {
            throw new RateNotFoundException('В данный момент данная пара не отслеживалась');
        }

        return $trackingResult->getRate();
    }
}
