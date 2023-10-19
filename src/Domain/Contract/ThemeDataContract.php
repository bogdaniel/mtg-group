<?php
declare(strict_types=1);

namespace App\Domain\Contract;
interface ThemeDataContract
{
    public function __construct(
        ?string $name,
        ?string $title,
        ?string $description,
        ?string $license,
        array $authors,
        ?string $version,
        ?string $homepage,
        bool $isActive,
        ?ThemeDataContract $parentTheme
    );
}
