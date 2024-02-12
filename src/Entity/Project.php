<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $yearStarted = null;

    #[ORM\Column(nullable: true)]
    private ?int $yearEnded = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'projects')]
    private ?ProjectPump $pump = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getYearStarted(): ?int
    {
        return $this->yearStarted;
    }

    public function setYearStarted(int $yearStarted): static
    {
        $this->yearStarted = $yearStarted;

        return $this;
    }

    public function getYearEnded(): ?int
    {
        return $this->yearEnded;
    }

    public function setYearEnded(?int $yearEnded): static
    {
        $this->yearEnded = $yearEnded;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ProjectPump>
     */
    public function getProjectPumps(): Collection
    {
        return $this->projectPumps;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getPump(): ?ProjectPump
    {
        return $this->pump;
    }

    public function setPump(?ProjectPump $pump): static
    {
        $this->pump = $pump;

        return $this;
    }
}
