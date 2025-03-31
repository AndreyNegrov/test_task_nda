<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\TrackingCurrencyPair;
use DateTime;

interface TrackingCurrencyPairRepositoryInterface
{
    public function save(TrackingCurrencyPair $trackingCurrencyPair): void;

    public function getLastPair(string $baseCurrency, string $targetCurrency): ?TrackingCurrencyPair;

    /**
     * @return TrackingCurrencyPair[]
     */
    public function getAllIsTracked(): array;

    public function getTrackingPairInDateTime(string $baseCurrency, string $targetCurrency, DateTime $targetDate): ?TrackingCurrencyPair;
}
