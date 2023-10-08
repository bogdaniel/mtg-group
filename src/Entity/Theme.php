<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;
use App\Repository\ThemeRepository;

#[Entity(repositoryClass: ThemeRepository::class)]
class Theme
{
    #[Id, GeneratedValue, Column(type: "integer")]
    private $id;

    #[Column(type: "string", length: 255)]
    private $name;

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

    public function __construct(string $name, string $description, string $author)
    {
        $this->name = $name;
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

    public function getAuthor(): string
    {
        return $this->author;
    }
}
