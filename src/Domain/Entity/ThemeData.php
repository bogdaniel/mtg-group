<?php

namespace App\Domain\Entity;

use App\Domain\Contract\ThemeDataContract;
use App\Domain\Traits\StaticCreateSelf;
use App\Domain\Traits\ToArray;
use App\Domain\Traits\ToEntity;

class ThemeData implements ThemeDataContract
{
    use StaticCreateSelf;
    use ToArray;
    use ToEntity;

    public ?string $name = null;
    public ?string $title = null;
    public ?string $description = null;
    public array $authors = [];
    public ?string $version = null;
    public ?string $license = null;
    public ?string $homepage = null;
    public bool $isActive = false;
    public ?int $parentThemeId = null;

    private ?ThemeData $parentTheme = null;

    public function __construct(
        string $name,
        string $title,
        string $description,
        string $license,
        array $authors,
        string $version,
        string $homepage,
        bool $isActive = false,
        ?ThemeData $parentTheme = null
    ) {}

    public function getParentTheme(): ?ThemeData
    {
        return $this->parentTheme;
    }

    public function setParentTheme(?ThemeData $parentTheme): self
    {
        $this->parentTheme = $parentTheme;

        return $this;
    }
}
