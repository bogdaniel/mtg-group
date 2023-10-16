<?php

namespace App\Service;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ThemeRuntimeConfigurator
{
    private FilesystemLoader $twig;
    private ThemeManager $themeManager;
    private string $projectDir;

    public function __construct(FilesystemLoader $twig, ThemeManager $themeManager, string $projectDir)
    {
        $this->twig = $twig;
        $this->themeManager = $themeManager;
        $this->projectDir = $projectDir;
        $this->configure();
    }

    public function configure(): void
    {
        $activeThemeName = $this->themeManager->getActiveThemeName();
        if ($activeThemeName !== null) {
            $themeNamespace = str_replace('/', ':', $activeThemeName);
            $this->twig->addPath($this->projectDir . '/themes/' . $activeThemeName, $themeNamespace);
//            dd($this->twig->getNamespaces());
        }
    }
}
