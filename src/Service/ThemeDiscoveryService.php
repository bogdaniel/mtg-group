<?php

namespace App\Service;

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

    private function getThemesFromDirectory(string $directory): array
    {
        $themes = [];
        $finder = new Finder();
        $finder->directories()->in($this->projectDir . '/' . $directory)->depth(1);

        foreach ($finder as $dir) {
            $composerJsonPath = $dir->getRealPath() . '/composer.json';
            if ($this->filesystem->exists($composerJsonPath)) {
                $composerJson = json_decode(file_get_contents($composerJsonPath), true, 512, JSON_THROW_ON_ERROR);
                if ($composerJson['type'] === 'ai-cms-theme') {
                    $themeData = ThemeData::create($composerJson);
                    $themes[] = $themeData;
                }
            }
        }

        return $themes;
    }

    public function discoverThemes(): void
    {
        $themesDirectories = ['themes', 'vendor'];
        foreach ($themesDirectories as $directory) {
            $themes = $this->getThemesFromDirectory($directory);
            foreach ($themes as $themeData) {
                $theme = $this->themeManager->findThemeByName($themeData->name);
                if (null === $theme) {
                    $this->themeManager->createTheme($themeData);
                } else {
                    $this->themeManager->updateTheme($theme->id, $themeData);
                }
            }
        }

        $activeTheme = $this->themeManager->getActiveThemeName();
        if ($activeTheme === null) {
            $themes = $this->themeManager->findAllThemes();
            if (count($themes) > 0) {
                $this->themeManager->setActiveTheme($themes[0]->id);
            }
        }
    }
}
