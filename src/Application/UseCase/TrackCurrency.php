<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\CurrencyProvider\ClientInterface;
use App\Application\CurrencyProvider\Factory\TrackRequestModelFactory;
use App\Application\CurrencyProvider\Model\TrackResponseModel;
use App\Domain\Entity\TrackingResult;
use App\Domain\Exception\CurrencyCodeNotExistException;
use App\Domain\Repository\TrackingCurrencyPairRepositoryInterface;
use App\Domain\Repository\TrackingResultRepositoryInterface;
use App\Domain\UseCase\RemoveTrackingInterface;
use App\Domain\UseCase\TrackCurrencyInterface;

readonly class TrackCurrency implements TrackCurrencyInterface
{
    public function __construct(
        private TrackingCurrencyPairRepositoryInterface $trackingCurrencyPairRepository,
        private TrackingResultRepositoryInterface $trackingResultRepository,
        private ClientInterface $currencyProviderClient,
        private TrackRequestModelFactory $trackRequestModelFactory,
        private RemoveTrackingInterface $removeTracking,
    ) {
    }

    public function process(): void
    {
        $trackedCurrencyPairs = $this->trackingCurrencyPairRepository->getAllIsTracked();
        $trackRequestModels = $this->trackRequestModelFactory->create($trackedCurrencyPairs);

        $trackResponses = [];
        foreach ($trackRequestModels as $requestModel) {
            try {
                $response = $this->currencyProviderClient->getRates($requestModel);
            } catch (CurrencyCodeNotExistException $exception) {
                continue;
            }
            $trackResponses[$requestModel->baseCurrencyCode] = $response;
        }

        foreach ($trackedCurrencyPairs as $pair) {

            $previousRate = $this->trackingResultRepository->getLastByPair($pair)?->getRate();

            try {
                $baseCurrencyResponses = $trackResponses[$pair->getBaseCurrency()] ?? null;
                if ($baseCurrencyResponses === null) {
                    throw new CurrencyCodeNotExistException("Currency {$pair->getBaseCurrency()} not exist in currency provider");
                }

                $currentRate = $this->getCurrentRateFromResult(
                    $pair->getTargetCurrency(),
                    $trackResponses[$pair->getBaseCurrency()] ?? null
                );
            } catch (CurrencyCodeNotExistException $exception) {
                $this->removeTracking->process(
                    $pair->getBaseCurrency(),
                    $pair->getTargetCurrency(),
                    $exception->getMessage()
                );

                continue;
            }

            if ($previousRate === $currentRate) {
                continue;
            }

            $this->trackingResultRepository->save(new TrackingResult($pair, $currentRate));
        }
    }

    /**
     * @param TrackResponseModel[] $responseRates
     */
    private function getCurrentRateFromResult(string $targetCurrency, array $responseRates): float
    {
        foreach ($responseRates as $responseRate) {
            if ($responseRate->currencyCode === $targetCurrency) {
                return $responseRate->rate;
            }
        }

        throw new CurrencyCodeNotExistException("Currency {$targetCurrency} not exist in currency provider");
    }
}
