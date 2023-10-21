<?php
declare(strict_types=1);

namespace App\Domain\Contract;
interface ThemeDataContract
{
    public function __construct(
        bool $isActive,
        ?ThemeDataContract $parentTheme,
        array $authors,
        ?string $name,
        ?string $title,
        ?string $description,
        ?string $license,
        ?string $version,
        ?string $homepage,
        ?int $id = null
    );
}
