<?php

namespace App\Service;

use App\Service\ThemeManager;
use App\Domain\Entity\ThemeData;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ThemeDiscoveryService
{
    private Filesystem $filesystem;
    private \App\Service\ThemeManager $themeManager;

    public function __construct(ThemeManager $themeManager, Filesystem $filesystem)
    {
        $this->themeManager = $themeManager;
        $this->filesystem = $filesystem;
    }

    public function discoverThemes(): void
    {
        $finder = new Finder();
        $finder->directories()->in('themes')->depth(1);

        foreach ($finder as $dir) {
            $composerJsonPath = $dir->getRealPath() . '/composer.json';
            dump($composerJsonPath);
            if ($this->filesystem->exists($composerJsonPath)) {
                $composerJson = json_decode(file_get_contents($composerJsonPath), true, 512, JSON_THROW_ON_ERROR);

                $themeData = ThemeData::create($composerJson);
                $theme = $this->themeManager->findThemeByName($themeData->name);
                if (null === $theme) {
                    $this->themeManager->createTheme($themeData);
                } else {
                    $this->themeManager->updateTheme($theme->id, $themeData);
                }
            }
        }

        // Check if there is an active theme
        $activeTheme = $this->themeManager->getActiveThemeName();
        if ($activeTheme === null) {
            // Get all themes
            $themes = $this->themeManager->findAllThemes();
            if (count($themes) > 0) {
                // Set the first theme as the active theme
                $this->themeManager->setActiveTheme($themes[0]->id);
            }
        }
    }
}
