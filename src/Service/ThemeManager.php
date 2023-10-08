<?php

namespace App\Service;

use App\Entity\Theme;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;

class ThemeManager
{
    private $themeRepository;
    public function __construct(ThemeRepository $themeRepository)
    {
        $this->themeRepository = $themeRepository;
    }

    public function createTheme(string $name, string $title, string $description, string $author, bool $isActive): Theme
    {
        $theme = new Theme($name, $title, $description, $author, new \DateTime(), new \DateTime(), $isActive);
        $this->themeRepository->save($theme);

        return $theme;
    }

    public function updateTheme(int $id, string $name, string $title, string $description, string $author, bool $isActive): Theme
    {
        $theme = $this->findTheme($id);
        if ($theme) {
            $updatedTheme = new Theme($name, $title, $description, $author, new \DateTime(), new \DateTime(), $isActive, $id);
            $this->themeRepository->save($updatedTheme);
            return $updatedTheme;

        }

        throw new \RuntimeException('Theme not found');
    }

    public function deleteTheme(Theme $theme): void
    {
        $this->themeRepository->delete($theme);
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
        $this->themeRepository->setActive($id);
    }
}
