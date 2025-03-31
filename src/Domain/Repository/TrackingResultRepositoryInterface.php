<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\TrackingResult;
use App\Domain\Entity\TrackingCurrencyPair;
use DateTime;

interface TrackingResultRepositoryInterface
{
    public function save(TrackingResult $trackingResult): void;

    public function getLastByPair(TrackingCurrencyPair $trackingCurrencyPair): ?TrackingResult;

    public function getTrackingResultInDateTime(TrackingCurrencyPair $pairInTargetDate, DateTime $targetDate): ?TrackingResult;
}
