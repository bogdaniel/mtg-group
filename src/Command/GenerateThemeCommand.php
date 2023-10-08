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
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the theme.')
            ->addArgument('description', InputArgument::REQUIRED, 'The description of the theme.')
            ->addArgument('license', InputArgument::REQUIRED, 'The license of the theme.')
            ->addArgument('author', InputArgument::REQUIRED, 'The author of the theme.');
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

        $composerJson = [
            "name" => $themeName,
            "description" => $input->getArgument('description'),
            "license" => $input->getArgument('license'),
            "authors" => [
                [
                    "name" => $input->getArgument('author'),
                    "email" => ""
                ]
            ]
        ];

        $filesystem->dumpFile("$themeDir/composer.json", json_encode($composerJson, JSON_PRETTY_PRINT));

        $output->writeln("Theme $themeName generated successfully.");

        return Command::SUCCESS;
    }
}
