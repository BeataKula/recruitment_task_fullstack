<?php

declare(strict_types=1);

namespace App\Factory;

use App\DTO\CurrencyDTO;

class CurrencyDTOFactory
{
    public function createCurrencyDTO(array $currencyConfiguration, float $referenceRate, string $date): CurrencyDTO {
        $sellRate = $referenceRate + $currencyConfiguration['sellAdjustment'];
        $buyRate = $currencyConfiguration['buyEnabled'] ? $referenceRate - $currencyConfiguration['buyAdjustment'] : null;

        return new CurrencyDTO($currencyConfiguration['code'], $currencyConfiguration['name'], $date, $referenceRate, $buyRate, $sellRate);
    }
}