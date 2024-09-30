<?php

declare(strict_types=1);

namespace App\Model;

use App\DTO\currencyDTOCollection;

class ApiResponse {

    public $httpResponseCode;
    public $errorMessages;
    public $selectedDate;
    public $currencyDTOCollection;

    public function __construct(int $httpResponseCode, array $errorMessages, string $selectedDate, currencyDTOCollection $currencyDTOCollection) {
        $this->httpResponseCode = $httpResponseCode;
        $this->errorMessages = $errorMessages;
        $this->selectedDate = $selectedDate;
        $this->currencyDTOCollection = $currencyDTOCollection;
    }
}