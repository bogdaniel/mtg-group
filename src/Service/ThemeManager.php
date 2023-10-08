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

    public function createTheme(string $name, string $title, string $description, string $author, bool $isActive, ?int $id = null): Theme
    {
        $theme = new Theme($name, $title, $description, $author, new \DateTime(), new \DateTime(), $isActive, $id);
        $this->entityManager->persist($theme);
        $this->entityManager->flush();

        return $theme;
    }

    public function updateTheme(int $id, string $name, string $title, string $description, string $author, bool $isActive): Theme
    {
        $theme = $this->findTheme($id);
        if ($theme) {
            $updatedTheme = new Theme($name, $title, $description, $author, new \DateTime(), new \DateTime(), $isActive, $id);
            $this->entityManager->persist($updatedTheme);
            $this->entityManager->flush();
        }

        return $updatedTheme;
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
