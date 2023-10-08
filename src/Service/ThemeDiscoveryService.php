<?php

namespace App\Service;

use App\Entity\Theme;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ThemeDiscoveryService
{
    private $themeRepository;
    private $entityManager;
    private $filesystem;

    public function __construct(ThemeRepository $themeRepository, EntityManagerInterface $entityManager, Filesystem $filesystem)
    {
        $this->themeRepository = $themeRepository;
        $this->entityManager = $entityManager;
        $this->filesystem = $filesystem;
    }

    public function discoverThemes(): void
    {
        $finder = new Finder();
        $finder->directories()->in('themes')->depth('== 0');

        foreach ($finder as $dir) {
            $themeName = $dir->getBasename();
            $theme = $this->themeRepository->findOneBy(['name' => $themeName]);

            $composerJsonPath = $dir->getRealPath() . '/composer.json';

            if ($this->filesystem->exists($composerJsonPath)) {
                $composerJson = json_decode(file_get_contents($composerJsonPath), true, 512, JSON_THROW_ON_ERROR);

                $themeTitle = $composerJson['title'] ?? '';
                $theme = $this->themeRepository->findOneBy(['name' => $themeName]);
                if (!$theme) {
                    $theme = new Theme($themeName, $themeTitle, $composerJson['description'] ?? '', $composerJson['authors'][0]['name'] ?? '');
                    $this->entityManager->persist($theme);
                } else {
                    $theme->setTitle($themeTitle);
                }
                $this->entityManager->persist($theme);
            }
        }

        $this->entityManager->flush();
    }
}
