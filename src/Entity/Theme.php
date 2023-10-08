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
    private $id;

    #[Column(type: "string", length: 255)]
    private $name;

    #[Column(type: "string", length: 255)]
    private $title;

    #[Column(type: "string", length: 255)]
    private $description;

    #[Column(type: "string", length: 255)]
    private $author;

    #[Column(type: "datetime")]
    private $createdAt;

    #[Column(type: "datetime")]
    private $updatedAt;

    #[Column(type: "boolean")]
    private $isActive;

    public function __construct(string $name, string $title, string $description, string $author)
    {
        $this->name = $name;
        $this->title = $title;
        $this->description = $description;
        $this->author = $author;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->isActive = false;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setActive(bool $active): void
    {
        $this->isActive = $active;
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }
}
