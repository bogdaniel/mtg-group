<?php
declare(strict_types=1);

namespace App\Service;

use App\Domain\Contract\ThemeDataContract;
use Symfony\Component\Filesystem\Filesystem;

class ThemeFilesystemService
{
    private Filesystem $filesystem;
    private string $projectDir;

    public function __construct(Filesystem $filesystem, $projectDir)
    {
        $this->filesystem = $filesystem;
        $this->projectDir = $projectDir;
    }

    public function createThemeDirectories(string $themeDir): void
    {
        if (!$this->filesystem->exists($themeDir)) {
            $this->filesystem->mkdir([
                $themeDir,
                "$themeDir/templates",
                "$themeDir/templates/bundles",
                "$themeDir/translations",
                "$themeDir/assets",
                "$themeDir/assets/css",
                "$themeDir/assets/scss",
                "$themeDir/assets/javascript",
                "$themeDir/assets/images",
                "$themeDir/assets/fonts",
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
        $childThemeDir = $this->projectDir . '/themes/' . $childThemeData->name;
        $this->filesystem->mirror($this->projectDir . '/themes/' . $parentThemeName, $childThemeDir, null, ['copy_on_windows' => true]);
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
