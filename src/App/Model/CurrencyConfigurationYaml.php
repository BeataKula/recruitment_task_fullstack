<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class CurrencyConfigurationYaml implements CurrencyConfigurationInterface
{

    private $currencies;

    public function __construct()
    {
        $yamlFilePath = __DIR__ . '/../../../config/currencies.yaml';
        if (!file_exists($yamlFilePath)) {
            throw new \Exception("YAML file not found: " . $yamlFilePath);
        }

        try {
            // Parse the YAML file into an array
            $this->currencies = Yaml::parseFile($yamlFilePath);
        } catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
    }

    public function getCurrencyConfiguration(): array
    {
        return $this->currencies;
    }
}
