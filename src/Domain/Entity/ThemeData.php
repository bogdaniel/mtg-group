<?php

namespace App\Domain\Entity;

use App\Domain\Contract\ThemeDataContract;

class ThemeData implements ThemeDataContract
{
    public string $name;
    public string $title;
    public string $description;
    public array $authors;
    public string $version;
    public string $homepage;
    public bool $isActive;

    public function __construct(
        string $name,
        string $title,
        string $description,
        array $authors,
        string $version,
        string $homepage,
        bool $isActive
    ) {
        $this->name = $name;
        $this->title = $title;
        $this->description = $description;
        $this->authors = $authors;
        $this->version = $version;
        $this->homepage = $homepage;
        $this->isActive = $isActive;
    }
}
