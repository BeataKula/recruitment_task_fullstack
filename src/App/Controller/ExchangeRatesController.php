<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ExchangeRateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\DTO\CurrencyDTO;
use App\DTO\CurrencyDTOCollection;
use App\Model\ApiResponse;
use App\Service\ApiResponseSerializerService;

use DateTime;


class ExchangeRatesController extends AbstractController
{
    private $exchangeRateService;

    public function __construct(ExchangeRateService $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }

    public function index(Request $request): Response
    {
        $date = $request->query->get('date');
        $selectedDate = $date ? new DateTime($date) : new DateTime('');

        $currencyDTOCollection =  $this->exchangeRateService->getCurrencyCollection($selectedDate->format('Y-m-d'));

        $apiResponse = new ApiResponse(Response::HTTP_OK, [], $selectedDate->format('Y-m-d'), $currencyDTOCollection);

        $serializerService = new ApiResponseSerializerService();

        $responseContent = $serializerService->serializeToJson($apiResponse);

        return new Response(
            $responseContent,
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }
}
