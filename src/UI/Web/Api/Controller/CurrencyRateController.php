<?php

declare(strict_types=1);

namespace App\UI\Web\Api\Controller;

use App\Domain\Exception\RateNotFoundException;
use App\Domain\UseCase\GetRateInterface;
use App\UI\Web\Api\Controller\Request\GetRateRequest;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyRateController extends AbstractController
{
    public function __construct(
        private readonly GetRateInterface $getRate,
    ) {
    }

    #[Route('/api/rate', name: 'api_rates', methods: ['GET'])]
    public function getRate(
        #[MapQueryString] GetRateRequest $request,
    ): Response
    {
        try {
            $date = new DateTime($request->date);
        } catch (\Exception $e) {
            return new Response('field `date` incorrect. Use YYYY-MM-DD HH:MM format', Response::HTTP_BAD_REQUEST);
        }

        try {
            $result = $this->getRate->process($request->baseCurrency, $request->targetCurrency, $date);
        } catch (RateNotFoundException $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['result' => $result], Response::HTTP_OK);
    }
}
