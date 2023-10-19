<?php

namespace App\Domain\Entity;

use App\Domain\Contract\ThemeDataContract;
use App\Domain\Traits\StaticCreateFromEntity;
use App\Domain\Traits\StaticCreateSelf;
use App\Domain\Traits\ToArray;
use App\Domain\Traits\ToEntity;

class ThemeData implements ThemeDataContract
{
    use StaticCreateSelf;
    use ToArray;
    use ToEntity;
    use StaticCreateFromEntity;

    public function __construct(
        public ?string $name = null,
        public ?string $title = null,
        public ?string $description = null,
        public ?string $license = null,
        public array $authors = [],
        public ?string $version = null,
        public ?string $homepage = null,
        public bool $isActive = false,
        public ?ThemeDataContract $parentTheme = null
    ) {
    }
}
