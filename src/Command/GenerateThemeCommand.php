<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Filesystem\Filesystem;

class GenerateThemeCommand extends Command
{
    protected static $defaultName = 'app:generate-theme';

    protected function configure()
    {
        $this
            ->setDescription('Generates a new theme folder.')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the theme.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filesystem = new Filesystem();

        $themeName = ucwords($input->getArgument('name'));
        $themeDir = 'themes/' . $themeName;

        $filesystem->mkdir([
            $themeDir,
            "$themeDir/public",
            "$themeDir/templates",
            "$themeDir/templates/bundles",
            "$themeDir/translations",
        ]);

        $defaultComposerJson = [
            "name" => "",
            "description" => "",
            "license" => "MIT",
            "authors" => [
                [
                    "name" => "",
                    "email" => ""
                ]
            ]
        ];

        $filesystem->dumpFile("$themeDir/composer.json", json_encode($defaultComposerJson, JSON_PRETTY_PRINT));

        $output->writeln("Theme $themeName generated successfully.");

        return Command::SUCCESS;
    }
}
