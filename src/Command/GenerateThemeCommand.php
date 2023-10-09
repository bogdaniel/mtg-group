<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Filesystem;

class GenerateThemeCommand extends Command
{
    protected static $defaultName = 'app:generate-theme';

    protected function configure()
    {
        $this->setDescription('Generates a new theme folder.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question('Please enter the title of the theme: ');
        $themeTitle = ucwords($helper->ask($input, $output, $question));

        $question = new Question('Please enter the name of the theme: ');
        $themeName = strtolower(str_replace(' ', '-', $themeTitle));

        $question = new Question('Please enter the description of the theme: ');
        $description = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the license of the theme: ');
        $license = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the author of the theme: ');
        $author = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the email of the author: ');
        $email = $helper->ask($input, $output, $question);

        $filesystem = new Filesystem();

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
            "title" => $themeTitle,
            "description" => $description,
            "license" => $license,
            "authors" => [
                [
                    "name" => $author,
                    "email" => $email
                ]
            ]
        ];

        $filesystem->dumpFile("$themeDir/composer.json", json_encode($composerJson, JSON_PRETTY_PRINT));

        $output->writeln("Theme $themeName generated successfully.");

        return Command::SUCCESS;
    }
}
