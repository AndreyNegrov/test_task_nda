<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

interface TrackCurrencyInterface
{
    public function process(): void;
}
