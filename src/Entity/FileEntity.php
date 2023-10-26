<?php

namespace App\Entity;

use App\Entity\Contract\FileEntityContract;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class FileEntity implements FileEntityContract
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue(strategy: 'AUTO')]
        #[ORM\Column(type: 'datetime')] public \DateTimeInterface $createDate,
        #[ORM\Column(type: 'datetime')] public \DateTimeInterface $updateDate,
        #[ORM\Column(type: 'datetime', nullable: true)] public ?\DateTimeInterface $deleteDate,
        #[ORM\Column(type: 'integer')] public ?int $id = null,
        #[ORM\Column(type: 'string', length: 255)] public string $name = '',
        #[ORM\Column(type: 'integer')] public int $size = 0,
        #[ORM\Column(type: 'string', length: 255)] public string $mimeType = '',
        #[ORM\Column(type: 'string', length: 255)] public string $checksum = '',
        #[ORM\Column(type: 'json')] public array $metadata = [],
    ) {
    }
}
