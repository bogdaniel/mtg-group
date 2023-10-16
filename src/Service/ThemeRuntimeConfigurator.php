<?php

namespace App\Service;

use App\Event\AfterAddPathEvent;
use App\Event\AfterThemeNamespaceEvent;
use App\Event\BeforeAddPathEvent;
use App\Event\BeforeThemeNamespaceEvent;
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
    }

    public function configure(): void
    {
        $activeThemeName = $this->themeManager->getActiveThemeName();
        if ($activeThemeName !== null) {
            $this->eventDispatcher->dispatch(new BeforeThemeNamespaceEvent($activeThemeName));
            $themeNamespace = str_replace('/', ':', $activeThemeName);
            $this->eventDispatcher->dispatch(new AfterThemeNamespaceEvent($themeNamespace));
            $this->eventDispatcher->dispatch(new BeforeAddPathEvent($this->projectDir . '/themes/' . $activeThemeName, $themeNamespace));
            $this->twig->addPath($this->projectDir . '/themes/' . $activeThemeName, $themeNamespace);
            $this->eventDispatcher->dispatch(new AfterAddPathEvent($this->projectDir . '/themes/' . $activeThemeName, $themeNamespace));
        }
    }
}
