<?php

declare(strict_types=1);

namespace App\Model;

interface CurrencyConfigurationInterface {
    public function getCurrencyConfiguration(): array;
}
