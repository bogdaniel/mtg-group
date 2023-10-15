<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class ThemeGeneratedEvent extends Event
{
    public const NAME = 'theme.generated';

    protected string $packageName;

    public function __construct(string $packageName)
    {
        $this->packageName = $packageName;
    }

    public function getPackageName(): string
    {
        return $this->packageName;
    }
}
