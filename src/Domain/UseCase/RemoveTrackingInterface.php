<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

interface RemoveTrackingInterface
{
    public function process(string $baseCurrency, string $targetCurrency, ?string $error = null): void;
}
