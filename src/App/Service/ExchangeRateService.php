<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\DTO\CurrencyDTO;
use App\Model\ReferenceRateProviderInterface;
use App\Model\CurrencyConfigurationInterface;
use App\Factory\CurrencyDTOFactory;
use App\DTO\CurrencyDTOCollection;

class ExchangeRateService
{

    private $referenceRateProvider;
    private $currencyConfigurationProvider;
    private $currencyDTOFactory;

    public function __construct(ReferenceRateProviderInterface $referenceRateProvider, CurrencyConfigurationInterface $currencyConfigurationProvider, CurrencyDTOFactory $currencyDTOFactory)
    {
        $this->referenceRateProvider = $referenceRateProvider;
        $this->currencyConfigurationProvider = $currencyConfigurationProvider;
        $this->currencyDTOFactory = $currencyDTOFactory;
    }

    public function getCurrencyCollection($date): CurrencyDTOCollection
    {

        $currencyCollection = new CurrencyDTOCollection();

        $currencyConfigurations = $this->currencyConfigurationProvider->getCurrencyConfiguration();

        foreach ($currencyConfigurations as $currencyConfiguration) {
            $referenceRate = $this->referenceRateProvider->getReferenceRate($currencyConfiguration['code'], $date);
            $currencyCollection->add($this->currencyDTOFactory->createCurrencyDTO($currencyConfiguration, $referenceRate, $date));
        }

        return $currencyCollection;
    }
}
