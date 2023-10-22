<?php
declare(strict_types=1);

namespace App\Domain\Entity;

class ComposerJsonData
{
    public ?string $name;
    public ?string $type;
    public ?string $license;
    public ?string $description;
    public ?string $minimumStability;
    public ?bool $preferStable;
    public array $require;
    public array $requireDev;
    public array $scripts;
    public array $replace;
    public array $extra;

    public function __construct(
        ?string $name,
        ?string $type,
        ?string $license,
        ?string $description,
        ?string $minimumStability,
        ?bool $preferStable,
        array $require,
        array $requireDev,
        array $scripts,
        array $replace,
        array $extra
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->license = $license;
        $this->description = $description;
        $this->minimumStability = $minimumStability;
        $this->preferStable = $preferStable;
        $this->require = $require;
        $this->requireDev = $requireDev;
        $this->scripts = $scripts;
        $this->replace = $replace;
        $this->extra = $extra;
    }
}
