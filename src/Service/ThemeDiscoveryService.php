<?php
declare(strict_types=1);

namespace App\Service;

use App\Domain\Entity\ThemeData;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;

class ThemeDiscoveryService
{
    private Filesystem $filesystem;
    private \App\Service\ThemeManager $themeManager;
    private KernelInterface $kernel;

    public function __construct(ThemeManager $themeManager, Filesystem $filesystem, KernelInterface $kernel)
    {
        $this->themeManager = $themeManager;
        $this->filesystem = $filesystem;
        $this->kernel = $kernel;
    }

    public function discoverThemes(): array
    {
        $themesDirectories = ['themes', 'vendor'];
        $foundThemes = [];
        foreach ($themesDirectories as $directory) {
            $themes = $this->getThemesFromDirectory($directory);
            foreach ($themes as $themeData) {
                $theme = $this->themeManager->findThemeByName($themeData->name);
                if (null === $theme) {
                    $this->themeManager->createTheme($themeData);
                } else {
                    $this->themeManager->updateTheme($theme->id, $themeData);
                }

                $foundThemes[] = $themeData;
            }
        }

        $activeTheme = $this->themeManager->getActiveThemeName();
        if ($activeTheme === null) {
            $themes = $this->themeManager->findAllThemes();
            if (count($themes) > 0) {
                $this->themeManager->setActiveTheme($themes[0]->id);
            }
        }

        return $foundThemes;
    }

    private function getThemesFromDirectory(string $directory): array
    {
        $themes = [];
        $finder = new Finder();
        $finder->directories()->in($this->kernel->getProjectDir() . '/' . $directory)->depth(1);

        foreach ($finder as $dir) {
            $composerJsonPath = $dir->getRealPath() . '/composer.json';
            if ($this->filesystem->exists($composerJsonPath)) {
                $composerJson = json_decode(file_get_contents($composerJsonPath), true, 512, JSON_THROW_ON_ERROR);
                if (isset($composerJson['type']) && (string)$composerJson['type'] === 'ai-cms-theme') {
                    $themeData = ThemeData::create($composerJson);
                    $themes[] = $themeData;
                }
            }
        }

        return $themes;
    }
}
