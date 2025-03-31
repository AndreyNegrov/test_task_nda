<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use DateTime;

interface GetRateInterface
{
    public function process(string $baseCurrency, string $targetCurrency, DateTime $dateTime): float;
}
