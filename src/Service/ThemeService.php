<?php

namespace App\Service;

class ThemeService
{
    private $themesDir;

    public function __construct(string $themesDir)
    {
        $this->themesDir = $themesDir;
    }

    public function loadStaticPage(string $themeName, string $pageName): string
    {
        $filePath = $this->themesDir . '/' . $themeName . '/pages/' . $pageName . '.html';

        if (!file_exists($filePath)) {
            throw new \Exception('Page not found');
        }

        return file_get_contents($filePath);
    }
}
