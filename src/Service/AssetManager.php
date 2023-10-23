<?php
declare(strict_types=1);

namespace App\Service;

use App\Domain\Contract\ThemeDataContract;
use App\Domain\Entity\Theme;

use Symfony\Component\Filesystem\Filesystem;

class AssetManager
{
    private string $projectDir;
    private Filesystem $filesystem;

    public function __construct(string $projectDir, Filesystem $filesystem)
    {
        $this->projectDir = $projectDir;
        $this->filesystem = $filesystem;
    }

    public function copyThemeAssetsToProjectRoot(ThemeDataContract $theme): void
    {
        $themeDir = $this->projectDir . '/themes/' . $theme->name;
        $filesToCopy = ['package.json', 'webpack.config.js', 'assets'];

        foreach ($filesToCopy as $file) {
            if ($this->filesystem->exists($themeDir . '/' . $file)) {
                if (is_dir($themeDir . '/' . $file)) {
                    $this->recursiveCopy($themeDir . '/' . $file, $this->projectDir . '/' . $file);
                } else {
                    $this->filesystem->copy($themeDir . '/' . $file, $this->projectDir . '/' . $file);
                }
            }
        }
    }

    private function recursiveCopy(string $src, string $dst): void
    {
        $dir = opendir($src);
        $this->filesystem->mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->recursiveCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    $this->filesystem->copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
