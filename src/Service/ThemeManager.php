<?php

namespace App\Service;

use App\Entity\Theme;
use App\Repository\ThemeRepository;

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
        $theme = $this->findThemeById($id);
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

    public function findThemeByName(string $name): ?Theme
    {
        return $this->themeRepository->findThemeByName($name);
    }

    public function findAllThemes(): array
    {
        return $this->themeRepository->findAll();
    }

    public function setActiveTheme(int $id): void
    {
        $theme = $this->findThemeById($id);
        if ($theme) {
            $updatedTheme = new Theme($theme->name, $theme->title, $theme->description, $theme->author, $theme->createdAt, new \DateTime(), 1, $id);
            $this->themeRepository->save($updatedTheme);
        }
    }

    public function findThemeById(int $id): ?Theme
    {
        return $this->themeRepository->find($id);
    }
}
