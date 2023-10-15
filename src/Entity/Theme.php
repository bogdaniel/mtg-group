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
        public string $name,
        #[Column(type: "string", length: 500)]
        public string $title,
        #[Column(type: "string", length: 255)]
        public string $description,
        #[Column(type: "json")]
        public array $authors,
        #[Column(type: "string", length: 255)]
        public string $version,
        #[Column(type: "string", length: 255)]
        public string $homepage,
        #[Column(type: "datetime")]
        public \DateTime $createdAt,
        #[Column(type: "datetime")]
        public \DateTime $updatedAt,
        #[Column(type: "boolean")]
        public bool $isActive = false,
        #[Id, GeneratedValue, Column(type: "integer")]
        public ?int $id = null,
        public ?Theme $parentTheme = null,
        #[Column(type: "json")]
        public array $childThemes = [],
    ) {}

    public function getParentTheme(): ?Theme
    {
        return $this->parentTheme;
    }

    public function setParentTheme(?Theme $parentTheme): self
    {
        $this->parentTheme = $parentTheme;

        return $this;
    }
}
