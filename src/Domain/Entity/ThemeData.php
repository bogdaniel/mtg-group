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

    public function __construct(
        string $name,
        string $title,
        string $description,
        string $license,
        array $authors,
        string $version,
        string $homepage,
        bool $isActive = false,
        ?int $parentThemeId = null
    ) {}
}
