<?php

namespace App\Domain\Contract;

interface ThemeDataContract
{
    public function __construct(
        string $name,
        string $title,
        string $description,
        string $license,
        array $authors,
        string $version,
        string $homepage,
        bool $isActive,
        ?int $parentThemeId
    );
}
