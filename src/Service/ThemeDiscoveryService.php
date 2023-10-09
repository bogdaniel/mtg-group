<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ThemeDiscoveryService
{
    private $filesystem;

    private $themeManager;

    public function __construct(ThemeManager $themeManager, Filesystem $filesystem)
    {
        $this->themeManager = $themeManager;
        $this->filesystem = $filesystem;
    }

    public function discoverThemes(): void
    {
        $finder = new Finder();
        $finder->directories()->in('themes')->depth('== 0');

        foreach ($finder as $dir) {
            $themeName = $dir->getBasename();
            $theme = $this->themeManager->findThemeByName($themeName);

            $composerJsonPath = $dir->getRealPath() . '/composer.json';

            if ($this->filesystem->exists($composerJsonPath)) {
                $composerJson = json_decode(file_get_contents($composerJsonPath), true, 512, JSON_THROW_ON_ERROR);

                $themeTitle = $composerJson['title'] ?? '';
                $description = $composerJson['description'] ?? '';
                $author = $composerJson['authors'][0]['name'] ?? '';

                if (!$theme) {
                    $this->themeManager->createTheme($themeName, $themeTitle, $description, $author, false);
                    continue;
                }

                $this->themeManager->updateTheme($theme->id, $themeName, $themeTitle, $description, $author, false);
            }
        }
    }
}
