<?php
declare(strict_types=1);

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class AfterThemeNamespaceEvent extends Event
{
    public const NAME = 'theme.after_theme_namespace';

    private string $themeNamespace;

    public function __construct(string $themeNamespace)
    {
        $this->themeNamespace = $themeNamespace;
    }

    public function getThemeNamespace(): string
    {
        return $this->themeNamespace;
    }
}
