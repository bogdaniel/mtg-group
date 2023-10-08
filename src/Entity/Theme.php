<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\ORM\Mapping\Table;
use App\Repository\ThemeRepository;

#[Entity(repositoryClass: ThemeRepository::class)]
#[Table(name: "theme", uniqueConstraints: [new UniqueConstraint(name: "theme_name_unique", columns: ["name"])])]
class Theme
{
    #[Id, GeneratedValue, Column(type: "integer")]
    protected readonly int $id;

    public function __construct(
        #[Column(type: "string", length: 255)]
        protected string $name,
        #[Column(type: "string", length: 255)]
        protected string $title,
        #[Column(type: "string", length: 255)]
        protected string $description,
        #[Column(type: "string", length: 255)]
        protected string $author,
        #[Column(type: "datetime")]
        protected \DateTime $createdAt,
        #[Column(type: "datetime")]
        protected \DateTime $updatedAt,
        #[Column(type: "boolean")]
        protected false $isActive
    ) {
    }
}
