<?php

namespace App\Service;

use Twig\Environment;

class ThemeRuntimeConfigurator
{
    private Environment $twig;
    private ThemeManager $themeManager;

    public function __construct(Environment $twig, ThemeManager $themeManager)
    {
        $this->twig = $twig;
        $this->themeManager = $themeManager;
    }

    public function configure(): void
    {
        $activeThemeName = $this->themeManager->getActiveThemeName();
        if ($activeThemeName !== null) {
            $this->twig->getLoader()->addPath('%kernel.project_dir%/themes/' . $activeThemeName, 'theme');
        }
    }
}
