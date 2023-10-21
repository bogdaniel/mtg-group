<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ThemeRepository;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
#[ORM\Table(name: "theme", uniqueConstraints: [new ORM\UniqueConstraint(name: "theme_name_unique", columns: ["name"])])]
class Theme
{
    #[ORM\OneToOne(mappedBy: 'parentTheme', targetEntity: self::class, cascade: ['persist', 'remove'])]
    public ?self $theme = null;

    public function __construct(
        #[ORM\Column(type: "string", length: 255)] public string $name,
        #[ORM\Column(type: "string", length: 500)] public string $title,
        #[ORM\Column(type: "string", length: 255)] public string $description,
        #[ORM\Column(type: "json")] public array $authors,
        #[ORM\Column(type: "string", length: 255)] public string $version,
        #[ORM\Column(type: "string", length: 255)] public string $license,
        #[ORM\Column(type: "string", length: 255)] public string $homepage,
        #[ORM\Column(type: "datetime")] public \DateTime $createdAt,
        #[ORM\Column(type: "datetime")] public \DateTime $updatedAt,
        #[ORM\Column(type: "boolean")] public bool $isActive = false,
        #[ORM\OneToOne(inversedBy: 'theme', targetEntity: self::class, cascade: [
            'persist',
            'remove'
        ])] public ?Theme $parentTheme = null,
        #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: "integer")] public ?int $id = null
    ) {
    }

    public function setTheme(?self $theme): static
    {
        // unset the owning side of the relation if necessary
        if ($theme === null && $this->theme !== null) {
            $this->theme->setParentTheme(null);
        }

        // set the owning side of the relation if necessary
        if ($theme !== null && $theme->getParentTheme() !== $this) {
            $theme->setParentTheme($this);
        }

        $this->theme = $theme;

        return $this;
    }

    public function setParentTheme(?self $parentTheme): static
    {
        $this->parentTheme = $parentTheme;

        return $this;
    }

    public function getParentTheme(): ?self
    {
        return $this->parentTheme;
    }
}
