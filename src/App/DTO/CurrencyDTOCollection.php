<?php

namespace App\DTO;

class CurrencyDTOCollection
{
    /**
     * @var CurrencyDTO[] An array to hold CurrencyDTO objects.
     */
    public $currencies = [];

    /**
     * Add a CurrencyDTO object to the collection.
     *
     * @param CurrencyDTO $currencyDTO The CurrencyDTO object to add.
     */
    public function add(CurrencyDTO $currencyDTO): void
    {
        $this->currencies[$currencyDTO->currencyCode] = $currencyDTO;
    }
}
