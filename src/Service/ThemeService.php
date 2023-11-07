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

        $directory = new \RecursiveDirectoryIterator($this->themesDir . '/' . $themeName . '/templates/pages/');
        $iterator = new \RecursiveIteratorIterator($directory);

        foreach ($iterator as $info) {
            if ($info->getFilename() === $pageName . '.html.twig') {
                return file_get_contents($info->getPathname());
            }
        }

        throw new \RuntimeException('Page not found');
    }
}
