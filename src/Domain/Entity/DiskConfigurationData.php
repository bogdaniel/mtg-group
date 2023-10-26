<?php

namespace App\Domain\Entity;

use App\Domain\Contract\DiskConfigurationDataContract;

class DiskConfigurationData implements DiskConfigurationDataContract
{
    public function __construct(public ?int $id, public array $configuration) {}
}
