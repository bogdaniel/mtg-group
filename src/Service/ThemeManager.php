<?php

namespace App\Service;

use App\DTO\ThemeData;
use App\Entity\Theme;
use App\Repository\ThemeRepository;

class ThemeManager
{
    private $themeRepository;
    public function __construct(ThemeRepository $themeRepository)
    {
        $this->themeRepository = $themeRepository;
    }

    public function createTheme(ThemeData $themeData): Theme
    {
        $theme = new Theme(
            $themeData->name,
            $themeData->title,
            $themeData->description,
            $themeData->author,
            new \DateTime(),
            new \DateTime(),
            $themeData->isActive
        );

        $this->themeRepository->save($theme);

        return $theme;
    }

    public function updateTheme(int $id, ThemeData $themeData): Theme
    {
        $theme = $this->findThemeById($id);
        if ($theme) {
            $updatedTheme = new Theme(
                $themeData->name,
                $themeData->title,
                $themeData->description,
                $themeData->author,
                new \DateTime(),
                new \DateTime(),
                $themeData->isActive,
                $id
            );
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
