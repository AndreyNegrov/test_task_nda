<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

interface AddTrackingInterface
{
    public function process(string $baseCurrency, string $targetCurrency): void;
}
