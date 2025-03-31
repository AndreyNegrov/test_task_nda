<?php

declare(strict_types=1);

namespace App\Application\CurrencyProvider\Model;

class TrackRequestModel
{
    /**
     * @param string[] $targetCurrencyCodes
     */
    public function __construct(
        public string $baseCurrencyCode,
        public array $targetCurrencyCodes,
    ) {
    }
}
