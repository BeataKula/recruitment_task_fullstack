<?php

namespace Unit\Service;

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\ExchangeRateService;
use App\DTO\CurrencyDTOCollection;
use App\Model\ReferenceRateProviderInterface;
use App\Model\CurrencyConfigurationInterface;
use App\Factory\CurrencyDTOFactory;
use App\DTO\CurrencyDTO;

class ExchangeRateServiceTest extends TestCase
{
    private $referenceRateProviderMock;
    private $currencyConfigurationProviderMock;
    private $currencyDTOFactoryMock;
    private $exchangeRateService;

    protected function setUp(): void
    {
        $this->referenceRateProviderMock = $this->createMock(ReferenceRateProviderInterface::class);
        $this->currencyConfigurationProviderMock = $this->createMock(CurrencyConfigurationInterface::class);
        $this->currencyDTOFactoryMock = $this->createMock(CurrencyDTOFactory::class);

        $this->exchangeRateService = new ExchangeRateService(
            $this->referenceRateProviderMock,
            $this->currencyConfigurationProviderMock,
            $this->currencyDTOFactoryMock
        );
    }

    public function testGetCurrencyCollection(): void
    {
        $currencyConfigurations = [
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'sellAdjustment' => 0.07,
                'buyAdjustment' => 0.05,
                'buyEnabled' => true,
            ],
        ];

        $this->currencyConfigurationProviderMock
            ->method('getCurrencyConfiguration')
            ->willReturn($currencyConfigurations);

        $this->referenceRateProviderMock
            ->method('getReferenceRate')
            ->with('EUR', '2023-09-30')
            ->willReturn(4.5);

        $currencyDTO = new CurrencyDTO('EUR', 'Euro', '2023-09-30', 4.5, 4.45, 4.57);
        $this->currencyDTOFactoryMock
            ->method('createCurrencyDTO')
            ->with($currencyConfigurations[0], 4.5, '2023-09-30')
            ->willReturn($currencyDTO);

        $result = $this->exchangeRateService->getCurrencyCollection('2023-09-30');

        $this->assertInstanceOf(CurrencyDTOCollection::class, $result);
        $this->assertCount(1, $result->currencies);

        $currencyDTO = $result->currencies['EUR'];
        $this->assertEquals('EUR', $currencyDTO->currencyCode);
        $this->assertEquals(4.5, $currencyDTO->referenceRate);
        $this->assertEquals(4.45, $currencyDTO->buyRate);
        $this->assertEquals(4.57, $currencyDTO->sellRate);
    }
}
