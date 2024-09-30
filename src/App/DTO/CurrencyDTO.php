<?php

namespace App\DTO;

class CurrencyDTO
{
    public $currencyCode;
    public $currencyName;
    public $date;
    public $referenceRate;
    public $buyRate;
    public $sellRate;


    public function __construct(string $currencyCode, string $currencyName, string $date, float $referenceRate, ?float $buyRate, ?float $sellRate) {
        $this->currencyCode = $currencyCode;
        $this->currencyName = $currencyName;
        $this->date = $date;
        $this->referenceRate = $referenceRate;
        $this->buyRate = $buyRate;
        $this->sellRate = $sellRate;
    }
}