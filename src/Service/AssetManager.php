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
        $filesToCopy = ['package.json', 'webpack.config.js', 'assets'];

        foreach ($filesToCopy as $file) {
            if (file_exists($themeDir . '/' . $file)) {
                if (is_dir($themeDir . '/' . $file)) {
                    $this->recursiveCopy($themeDir . '/' . $file, $this->projectDir . '/' . $file);
                } else {
                    copy($themeDir . '/' . $file, $this->projectDir . '/' . $file);
                }
            }
        }
    }

    private function recursiveCopy(string $src, string $dst): void
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->recursiveCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
