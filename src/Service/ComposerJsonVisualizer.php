<?php
declare(strict_types=1);

namespace App\Service;

class ComposerJsonVisualizer
{
    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function visualize(): array
    {
        $composerJsonPath = $this->projectDir . '/composer.json';
        $composerJson = json_decode(file_get_contents($composerJsonPath), true);

        return [
            'name' => $composerJson['name'] ?? null,
            'type' => $composerJson['type'] ?? null,
            'license' => $composerJson['license'] ?? null,
            'description' => $composerJson['description'] ?? null,
            'minimum-stability' => $composerJson['minimum-stability'] ?? null,
            'prefer-stable' => $composerJson['prefer-stable'] ?? null,
            'require' => $composerJson['require'] ?? [],
            'require-dev' => $composerJson['require-dev'] ?? [],
            'scripts' => $composerJson['scripts'] ?? [],
            'replace' => $composerJson['replace'] ?? [],
            'extra' => $composerJson['extra'] ?? [],
        ];
    }
}
