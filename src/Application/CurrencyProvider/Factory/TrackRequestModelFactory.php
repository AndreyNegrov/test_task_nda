<?php

declare(strict_types=1);

namespace App\Application\CurrencyProvider\Factory;

use App\Application\CurrencyProvider\Model\TrackRequestModel;
use App\Domain\Entity\TrackingCurrencyPair;

class TrackRequestModelFactory
{
    /**
     * @param TrackingCurrencyPair[] $trackedCurrencyPairSettings
     * @return TrackRequestModel[]
     */
    public function create(array $trackedCurrencyPairSettings): array
    {
        $groupByBaseCurrencyArray = [];

        foreach ($trackedCurrencyPairSettings as $currencyPairSetting) {
            $groupByBaseCurrencyArray[$currencyPairSetting->getBaseCurrency()][] = $currencyPairSetting->getTargetCurrency();
        }

        $requestModels = [];

        foreach ($groupByBaseCurrencyArray as $baseCurrency => $targetCurrency) {
            $requestModels[] = new TrackRequestModel($baseCurrency, $targetCurrency);
        }

        return $requestModels;
    }
}
