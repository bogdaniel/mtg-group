<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'uuid')]
    private ?Uuid $uuid = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 2)]
    private ?string $isoAlphaTwo = null;

    #[ORM\Column(length: 3)]
    private ?string $isoAlphaThree = null;

    #[ORM\Column(length: 3)]
    private ?string $isoNumeric = null;

    // Constructor to initialize UUID
    public function __construct()
    {
        $this->uuid = Uuid::v4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    public function setUuid(Uuid $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIsoAlphaTwo(): ?string
    {
        return $this->isoAlphaTwo;
    }

    public function setIsoAlphaTwo(string $isoAlphaTwo): static
    {
        $this->isoAlphaTwo = $isoAlphaTwo;

        return $this;
    }

    public function getIsoAlphaThree(): ?string
    {
        return $this->isoAlphaThree;
    }

    public function setIsoAlphaThree(string $isoAlphaThree): static
    {
        $this->isoAlphaThree = $isoAlphaThree;

        return $this;
    }

    public function getIsoNumeric(): ?string
    {
        return $this->isoNumeric;
    }

    public function setIsoNumeric(string $isoNumeric): static
    {
        $this->isoNumeric = $isoNumeric;

        return $this;
    }
}
