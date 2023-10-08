<?php

namespace App\Service;

use App\Entity\Theme;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;

class ThemeManager
{
    private $themeRepository;
    private $entityManager;

    public function __construct(ThemeRepository $themeRepository, EntityManagerInterface $entityManager)
    {
        $this->themeRepository = $themeRepository;
        $this->entityManager = $entityManager;
    }

    public function createTheme(string $name, string $title, string $description, string $author, bool $isActive): Theme
    {
        $theme = new Theme($name, $title, $description, $author, $isActive);
        $this->entityManager->persist($theme);
        $this->entityManager->flush();

        return $theme;
    }

    public function updateTheme(int $id, string $name, string $title, string $description, string $author, bool $isActive): Theme
    {
        $this->deleteTheme($id);

        return $this->createTheme($name, $title, $description, $author, $isActive);
    }

    public function deleteTheme(Theme $theme): void
    {
        $this->entityManager->remove($theme);
        $this->entityManager->flush();
    }

    public function findTheme(int $id): ?Theme
    {
        return $this->themeRepository->find($id);
    }

    public function findAllThemes(): array
    {
        return $this->themeRepository->findAll();
    }

    public function setActiveTheme(int $id): void
    {
        $theme = $this->findTheme($id);
        if ($theme) {
            $theme->setActive(true);
            $this->entityManager->flush();
        }
    }
}
