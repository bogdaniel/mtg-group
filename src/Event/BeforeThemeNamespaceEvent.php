<?php
declare(strict_types=1);

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class BeforeThemeNamespaceEvent extends Event
{
    public const NAME = 'theme.before_theme_namespace';

    private string $activeThemeName;

    public function __construct(string $activeThemeName)
    {
        $this->activeThemeName = $activeThemeName;
    }

    public function getActiveThemeName(): string
    {
        return $this->activeThemeName;
    }
}
