<?php

namespace App\Domain\Entity;

use App\Domain\Contract\ThemeDataContract;

class ThemeData implements ThemeDataContract
{
    public string $name;
    public string $title;
    public string $description;
    public string $author;
    public bool $isActive;

    public function __construct(
        string $name,
        string $title,
        string $description,
        string $author,
        bool $isActive
    ) {
        $this->name = $name;
        $this->title = $title;
        $this->description = $description;
        $this->author = $author;
        $this->isActive = $isActive;
    }
}
