<?php

namespace App\Entity;

use App\Entity\Contract\DiskConfigurationEntityContract;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class DiskConfiguration implements DiskConfigurationEntityContract
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue(strategy: 'AUTO')]
        #[ORM\Column(type: 'integer')] public ?int $id = null,
        #[ORM\Column(type: 'string', length: 255)] public ?string $name = null,
        #[ORM\Column(type: 'string', length: 255)] public ?string $type = null,
    ) {
    }
}
