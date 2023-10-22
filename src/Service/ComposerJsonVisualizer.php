<?php
declare(strict_types=1);

namespace App\Service;

use App\Domain\Entity\ComposerJsonData;

class ComposerJsonVisualizer
{
    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function visualize(): ComposerJsonData
    {
        $composerJsonPath = $this->projectDir . '/composer.json';
        $composerJson = json_decode(file_get_contents($composerJsonPath), true);

        $installedJsonPath = $this->projectDir . '/vendor/composer/installed.json';
        $installedJson = json_decode(file_get_contents($installedJsonPath), true);
        $installedPackages = array_column($installedJson['packages'], 'name');

        return new ComposerJsonData(
            $composerJson['name'] ?? null,
            $composerJson['type'] ?? null,
            $composerJson['license'] ?? null,
            $composerJson['description'] ?? null,
            $composerJson['minimum-stability'] ?? null,
            $composerJson['prefer-stable'] ?? null,
            $composerJson['require'] ?? [],
            $composerJson['require-dev'] ?? [],
            $composerJson['scripts'] ?? [],
            $composerJson['replace'] ?? [],
            $composerJson['extra'] ?? [],
            $installedPackages
        );
    }

    public function isPackageInstalled(string $packageName): bool
    {
        $installedJsonPath = $this->projectDir . '/vendor/composer/installed.json';
        $installedJson = json_decode(file_get_contents($installedJsonPath), true);
        $installedPackages = array_column($installedJson['packages'], 'name');

        return in_array($packageName, $installedPackages);
    }

    public function isPackageInRequireOrRequireDev(string $packageName): bool
    {
        $composerJsonPath = $this->projectDir . '/composer.json';
        $composerJson = json_decode(file_get_contents($composerJsonPath), true);

        return array_key_exists($packageName, $composerJson['require'] ?? []) || array_key_exists($packageName, $composerJson['require-dev'] ?? []);
    }
}
