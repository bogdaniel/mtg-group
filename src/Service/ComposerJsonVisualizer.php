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
            $composerJson['extra'] ?? []
        );
    }
}
