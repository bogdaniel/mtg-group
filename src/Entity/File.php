<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $size;

    #[ORM\Column(type: 'string', length: 255)]
    private string $mimeType;

    #[ORM\Column(type: 'string', length: 255)]
    private string $checksum;

    #[ORM\Column(type: 'json')]
    private array $metadata;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createDate;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updateDate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $deleteDate;

    // Add the necessary relationships and properties

    public function __construct(
        string $name,
        int $size,
        string $mimeType,
        string $checksum,
        array $metadata,
        \DateTimeInterface $createDate = null,
        \DateTimeInterface $updateDate = null,
        \DateTimeInterface $deleteDate = null
    ) {
        $this->name = $name;
        $this->size = $size;
        $this->mimeType = $mimeType;
        $this->checksum = $checksum;
        $this->metadata = $metadata;
        $this->createDate = $createDate ?: new \DateTimeImmutable();
        $this->updateDate = $updateDate ?: new \DateTimeImmutable();
        $this->deleteDate = $deleteDate;
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

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getChecksum(): string
    {
        return $this->checksum;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
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

    // Add getter and setter for relationships and other properties
}
