<?php

namespace App\Service;

use App\Domain\Contract\ThemeDataContract;
use App\Domain\Entity\ThemeData;
use App\Entity\Theme;
use App\Repository\ThemeRepository;

class ThemeManager
{
    private $themeRepository;

    public function __construct(ThemeRepository $themeRepository)
    {
        $this->themeRepository = $themeRepository;
    }

    public function createTheme(ThemeDataContract $themeData): Theme
    {
        $theme = new Theme(
            $themeData->name,
            $themeData->title,
            $themeData->description,
            $themeData->authors,
            $themeData->version,
            $themeData->homepage,
            new \DateTime(),
            new \DateTime(),
            $themeData->isActive
        );

        $this->themeRepository->save($theme);

        return $theme;
    }

    public function updateTheme(int $id, ThemeDataContract $themeData): Theme
    {
        $theme = $this->findThemeById($id);
        if ($theme) {
            $updatedTheme = new Theme(
                $themeData->name,
                $themeData->title,
                $themeData->description,
                $themeData->authors,
                $themeData->version,
                $themeData->homepage,
                $theme->createdAt,
                new \DateTime(),
                $themeData->isActive,
                $theme->id
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
            $updatedTheme = new Theme(
                $theme->name,
                $theme->title,
                $theme->description,
                $theme->authors,
                $theme->version,
                $theme->createdAt,
                new \DateTime(),
                1,
                $id
            );
            $this->themeRepository->save($updatedTheme);
        }
    }

    public function findThemeById(int $id): ?Theme
    {
        return $this->themeRepository->find($id);
    }
}
