<?php

declare(strict_types=1);

namespace App\Application\CurrencyProvider\Model;

readonly class TrackResponseModel
{
    public function __construct(
        public string $currencyCode,
        public float $rate,
    ) {
    }
}
