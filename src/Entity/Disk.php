<?php

namespace App\Entity;

use App\Domain\Traits\DiskEntityContract;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Disk implements DiskEntityContract
{
    public function __construct(
        #[ORM\Column(type: 'string', length: 255)] public ?string $name = null,
        #[ORM\Column(type: 'string', length: 255)] public ?string $path = null,
        #[ORM\Id]
        #[ORM\GeneratedValue(strategy: 'AUTO')]
        #[ORM\Column(type: 'integer')] public ?int $id = null,
    ) {
    }
}
