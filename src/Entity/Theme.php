<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\ORM\Mapping\Table;
use App\Repository\ThemeRepository;

#[Entity(repositoryClass: ThemeRepository::class, readOnly: true)]
#[Table(name: "theme", uniqueConstraints: [new UniqueConstraint(name: "theme_name_unique", columns: ["name"])])]
class Theme
{
    public function __construct(
        #[Column(type: "string", length: 255)]
        public readonly string $name,
        #[Column(type: "string", length: 500)]
        public readonly string $title,
        #[Column(type: "string", length: 255)]
        public readonly string $description,
        #[Column(type: "json")]
        public readonly array $authors,
        #[Column(type: "string", length: 255)]
        public readonly string $version,
        #[Column(type: "string", length: 255)]
        public readonly string $homepage,
        #[Column(type: "datetime")]
        public readonly \DateTime $createdAt,
        #[Column(type: "datetime")]
        public readonly \DateTime $updatedAt,
        #[Column(type: "boolean")]
        public readonly bool $isActive = false,
        #[Id, GeneratedValue, Column(type: "integer")]
        public ?int $id = null,
    ) {
    }
}
