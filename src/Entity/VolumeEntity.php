<?php

namespace App\Entity;

use App\Entity\Contract\VolumeEntityContract;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class VolumeEntity implements VolumeEntityContract
{
    public function __construct(
        #[ORM\Column(type: 'datetime')] public ?\DateTimeInterface $createDate = null,
        #[ORM\Column(type: 'datetime')] public ?\DateTimeInterface $updateDate = null,
        #[ORM\Column(type: 'datetime', nullable: true)] public ?\DateTimeInterface $deleteDate = null,
        #[ORM\Column(type: 'json')] public array $metadata = [],
        #[ORM\Id]
        #[ORM\GeneratedValue(strategy: 'AUTO')]
        #[ORM\Column(type: 'integer')] public ?int $id = null,
        #[ORM\Column(type: 'string', length: 255)] public ?string $name = null,
        #[ORM\Column(type: 'integer')] public ?int $size = 0,
        #[ORM\Column(type: 'boolean')] public bool $public = false,
    ) {
    }
}
