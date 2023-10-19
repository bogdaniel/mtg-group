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
        #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: "integer")] public ?int $id = null,
        #[ORM\OneToOne(inversedBy: 'theme', targetEntity: self::class, cascade: [
            'persist',
            'remove'
        ])] public ?Theme $parentTheme = null
    ) {
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function setAuthors(array $authors): static
    {
        $this->authors = $authors;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function getLicense(): ?string
    {
        return $this->license;
    }

    public function setLicense(string $license): static
    {
        $this->license = $license;

        return $this;
    }

    public function getHomepage(): ?string
    {
        return $this->homepage;
    }

    public function setHomepage(string $homepage): static
    {
        $this->homepage = $homepage;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheme(): ?self
    {
        return $this->theme;
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
