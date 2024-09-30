<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\DTO\CurrencyDTO;
use App\Model\ReferenceRateProviderInterface;
use App\Model\CurrencyConfigurationInterface;
use App\DTO\CurrencyDTOCollection;

class ExchangeRateService
{

    private $referenceRateProvider;
    private $currencyConfigurationProvider;

    public function __construct(ReferenceRateProviderInterface $referenceRateProvider, CurrencyConfigurationInterface $currencyConfigurationProvider)
    {
        $this->referenceRateProvider = $referenceRateProvider;
        $this->currencyConfigurationProvider = $currencyConfigurationProvider;
    }

    public function getCurrencyCollection($date): CurrencyDTOCollection
    {

        $currencyCollection = new CurrencyDTOCollection();

        $currencyConfigurations = $this->currencyConfigurationProvider->getCurrencyConfiguration();
        foreach ($currencyConfigurations as $currencyConfiguration) {
            $referenceRate = $this->referenceRateProvider->getReferenceRate($currencyConfiguration['code'], $date);
            $sellRate = $referenceRate + $currencyConfiguration['sellAdjustment'];
            if ($currencyConfiguration['buyEnabled']) {
                $buyRate = $referenceRate - $currencyConfiguration['buyAdjustment'];
                $currencyCollection->add(new currencyDTO($currencyConfiguration['code'], $currencyConfiguration['name'], $date, $referenceRate, $buyRate, $sellRate));
            } else {
                $currencyCollection->add(new currencyDTO($currencyConfiguration['code'], $currencyConfiguration['name'], $date, $referenceRate, null, $sellRate));
            }
        }

        return $currencyCollection;
    }
}
