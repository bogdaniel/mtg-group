<?php
declare(strict_types=1);

namespace App\Service;

use App\Domain\Contract\ThemeDataContract;
use App\Domain\Entity\ThemeData;
use App\Entity\Theme;
use App\Repository\ThemeRepository;

class ThemeManager
{
    private ThemeRepository $themeRepository;
    private ThemeFilesystemService $themeFilesystemService;

    public function __construct(ThemeRepository $themeRepository, ThemeFilesystemService $themeFilesystemService)
    {
        $this->themeRepository = $themeRepository;
        $this->themeFilesystemService = $themeFilesystemService;
    }

    public function createTheme(ThemeDataContract $themeData): Theme
    {
        $parentTheme = null;
        if (isset($themeData->parentTheme)) {
            $parentTheme = $this->findThemeByName($themeData->parentTheme->name);
        }
        $theme = new Theme(
            $themeData->name,
            $themeData->title,
            $themeData->description,
            $themeData->authors,
            $themeData->version,
            $themeData->license,
            $themeData->homepage,
            new \DateTime(),
            new \DateTime(),
            $themeData->isActive ?? false,
            $parentTheme
        );

        $theme->setParentTheme($parentTheme);

        $this->themeRepository->save($theme);

        return $theme;
    }

    public function updateTheme(int $id, ThemeDataContract $themeData): Theme
    {
        $theme = $this->findThemeById($id);
        if ($theme) {
            $theme->name = $themeData->name;
            $theme->title = $themeData->title;
            $theme->description = $themeData->description;
            $theme->authors = $themeData->authors;
            $theme->version = $themeData->version;
            $theme->license = $themeData->license;
            $theme->homepage = $themeData->homepage;
            new \DateTime();
            $theme->isActive = $themeData->isActive;
            if ($themeData->parentTheme) {
                $theme->parentTheme = $this->findThemeByName($themeData->parentTheme->name);
            }

            $this->themeRepository->save($theme);

            return $theme;
        }

        throw new \RuntimeException('Theme not found');
    }

    public function findThemeById(int $id): ?Theme
    {
        return $this->themeRepository->find($id);
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
        $activeThemeId = $this->getActiveThemeId();
        if ($activeThemeId !== null && $activeThemeId !== $id) {
            $this->deactivateTheme($activeThemeId);
        }
        $theme = $this->findThemeById($id);
        if ($theme) {
            $theme->isActive = true;
            $this->themeRepository->save($theme);
        }
    }

    public function deactivateTheme(int $id): void
    {
        $theme = $this->findThemeById($id);
        if ($theme) {
            $themes = $this->findAllThemes();
            $activeThemes = array_filter($themes, function($theme) {
                return $theme->isActive;
            });
            if (count($activeThemes) <= 1) {
                throw new \Exception('Cannot deactivate the last active theme');
            }
            if ($theme->parentTheme) {
                $theme->parentTheme->isActive = true;
            }
            $theme->isActive = false;
            $this->themeRepository->save($theme);
        }
    }

    public function getActiveThemeId(): ?int
    {
        $themes = $this->findAllThemes();
        foreach ($themes as $theme) {
            if ($theme->isActive) {
                return $theme->id;
            }
        }

        return null;
    }

    public function getActiveThemeName(): ?string
    {
        $themes = $this->findAllThemes();
        foreach ($themes as $theme) {
            if ($theme->isActive) {
                return $theme->name;
            }
        }

        return null;
    }

    public function createChildTheme(int $id): void
    {
        $parentThemeEntity = $this->findThemeById($id);
        if(null === $parentThemeEntity) {
            throw new \Exception('Parent theme not found as registered');
        }

        $parentTheme = ThemeData::createFromEntity($parentThemeEntity);

        $childThemeData = new ThemeData(
            true,
            $parentTheme,
            $parentThemeEntity->authors,
            $parentThemeEntity->name . '-child',
            $parentThemeEntity->title . ' Child',
            $parentThemeEntity->description,
            $parentThemeEntity->license,
            $parentThemeEntity->version,
            $parentThemeEntity->homepage,
        );

        $this->themeFilesystemService->createChildThemeDirectoriesAndFiles($parentTheme->name, $childThemeData);
        $this->createTheme($childThemeData);
    }
}
