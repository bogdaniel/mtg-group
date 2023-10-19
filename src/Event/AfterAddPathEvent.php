<?php
declare(strict_types=1);

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class AfterAddPathEvent extends Event
{
    public const NAME = 'theme.after_add_path';

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
