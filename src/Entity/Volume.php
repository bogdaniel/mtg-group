<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Volume
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $size;

    #[ORM\Column(type: 'boolean')]
    private bool $private;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createDate;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updateDate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $deleteDate;

    #[ORM\Column(type: 'json')]
    private array $metadata;

    // Add the necessary relationships and properties

    public function __construct(string $name, int $size, bool $private, array $metadata)
    {
        $this->name = $name;
        $this->size = $size;
        $this->private = $private;
        $this->metadata = $metadata;
        $this->createDate = new \DateTimeImmutable();
        $this->updateDate = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function isPrivate(): bool
    {
        return $this->private;
    }

    public function getCreateDate(): \DateTimeInterface
    {
        return $this->createDate;
    }

    public function getUpdateDate(): \DateTimeInterface
    {
        return $this->updateDate;
    }

    public function getDeleteDate(): ?\DateTimeInterface
    {
        return $this->deleteDate;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    // Add getter and setter for relationships and other properties
}
