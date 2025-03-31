<?php

declare(strict_types=1);

namespace App\Infrastructure\CurrencyProvider\Freecurrencyapi;

use App\Application\CurrencyProvider\ClientInterface;
use App\Application\CurrencyProvider\Model\TrackRequestModel;
use App\Application\CurrencyProvider\Model\TrackResponseModel;
use App\Domain\Exception\CurrencyCodeNotExistException;
use FreeCurrencyApi\FreeCurrencyApi\FreeCurrencyApiClient;

readonly class Client implements ClientInterface
{
    public function __construct(
        private string $apiKey,
    ) {
    }

    public function getRates(TrackRequestModel $exchangeRateRequestModel): array
    {
        $freecurrencyapi = new FreeCurrencyApiClient($this->apiKey);
        $result = $freecurrencyapi->latest([
            'base_currency' => $exchangeRateRequestModel->baseCurrencyCode
        ]);

        $data = $result['data'] ?? null;

        if ($data === null) {
            throw new CurrencyCodeNotExistException("Currency {$exchangeRateRequestModel->baseCurrencyCode} not exist in FreeCurrencyApi");
        }

        $rates = [];

        foreach ($result['data'] as $code => $rate) {
            $rates[] = new TrackResponseModel($code, $rate);
        }

        return $rates;
    }
}
