<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ReferenceRateProviderNBP implements ReferenceRateProviderInterface
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getReferenceRate(string $currencyCode, string $date): ?float
    {
        $response = $this->client->request(
            'GET',
            sprintf('https://api.nbp.pl/api/exchangerates/rates/A/%s/%s/?format=json', $currencyCode, $date)
        );

        if ($response->getStatusCode() !== 200) {
            return null;
        }

        $rateData = $response->toArray();

        if (!empty($rateData['rates']) && !empty($rateData['rates'][0]) && !empty($rateData['rates'][0]['mid'])) {
            return $rateData['rates'][0]['mid'];
        }
        return null;
    }
}
