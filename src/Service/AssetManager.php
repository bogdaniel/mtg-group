<?php
declare(strict_types=1);

namespace App\Service;

use App\Domain\Contract\ThemeDataContract;
use App\Domain\Entity\Theme;

class AssetManager
{
    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function copyThemeAssetsToProjectRoot(ThemeDataContract $theme): void
    {
        $themeDir = $this->projectDir . '/themes/' . $theme->name;
        $filesToCopy = ['package.json', 'webpack.config.js'];

        foreach ($filesToCopy as $file) {
            if (file_exists($themeDir . '/' . $file)) {
                copy($themeDir . '/' . $file, $this->projectDir . '/' . $file);
            }
        }
    }
}
