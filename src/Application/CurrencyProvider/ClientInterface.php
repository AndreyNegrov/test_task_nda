<?php

declare(strict_types=1);

namespace App\Application\CurrencyProvider;

use App\Application\CurrencyProvider\Model\TrackRequestModel;
use App\Application\CurrencyProvider\Model\TrackResponseModel;

interface ClientInterface
{
    /**
     * @return TrackResponseModel[]
     */
    public function getRates(TrackRequestModel $exchangeRateRequestModel): array;
}
