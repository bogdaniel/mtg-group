<?php

namespace App\Service;

use Symfony\Component\Yaml\Yaml;

class FormBuilderConfigurationReader
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function parse(): array
    {
        return Yaml::parseFile($this->filePath);
    }
}
