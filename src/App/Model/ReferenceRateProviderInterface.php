<?php

declare(strict_types=1);

namespace App\Model;

interface ReferenceRateProviderInterface
{
    public function getReferenceRate(string $currencyCode, string $date): ?float;
}
