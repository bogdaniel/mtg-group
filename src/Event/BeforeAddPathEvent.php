<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class BeforeAddPathEvent extends Event
{
    public const NAME = 'theme.before_add_path';

    private string $path;
    private string $namespace;

    public function __construct(string $path, string $namespace)
    {
        $this->path = $path;
        $this->namespace = $namespace;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }
}
