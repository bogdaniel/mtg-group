<?php

namespace App\Service;

use App\Domain\Contract\ThemeDataContract;
use Symfony\Component\Filesystem\Filesystem;

class ThemeFilesystemService
{
    private Filesystem $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function createThemeDirectories(string $themeDir): void
    {
        if (!$this->filesystem->exists($themeDir)) {
            $this->filesystem->mkdir([
                $themeDir,
                "$themeDir/public",
                "$themeDir/templates",
                "$themeDir/templates/bundles",
                "$themeDir/translations",
            ]);
        }
    }

    public function createComposerJsonFile(string $themeDir, array $composerJson): void
    {
        $this->filesystem->dumpFile("$themeDir/composer.json",
            json_encode($composerJson, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }

    public function createChildThemeDirectoriesAndFiles(string $parentThemeName, ThemeDataContract $childThemeData): void
    {
        $childThemeDir = 'themes/' . $childThemeData->name;
        $this->filesystem->mirror('themes/' . $parentThemeName, $childThemeDir);
        $composerJson = [
            "name" => $childThemeData->name,
            "title" => $childThemeData->title,
            "description" => $childThemeData->description,
            "license" => $childThemeData->license,
            "version" => $childThemeData->version,
            "homepage" => $childThemeData->homepage,
            "authors" => $childThemeData->authors,
            "type" => "ai-cms-theme",
            "tags" => [],
        ];
        $this->createComposerJsonFile($childThemeDir, $composerJson);
    }
}
