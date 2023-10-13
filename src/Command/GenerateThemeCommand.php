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

        $question = new Question('Please enter the package name of the theme: ');
        $packageName = strtolower($helper->ask($input, $output, $question));

        $question = new Question('Please enter the description of the theme: ');
        $description = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the license of the theme: ');
        $license = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the author of the theme: ');
        $author = ucwords($helper->ask($input, $output, $question));

        $question = new Question('Please enter the email of the author: ');
        $email = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the version of the theme: ');
        $version = $helper->ask($input, $output, $question);

        $filesystem = new Filesystem();

        $packageNameCompiled = strtolower(str_replace(' ', '-', $themeTitle));
        $themeDir = 'themes/' . $packageNameCompiled;

        $filesystem->mkdir([
            $themeDir,
            "$themeDir/public",
            "$themeDir/templates",
            "$themeDir/templates/bundles",
            "$themeDir/translations",
        ]);


        $composerJson = [
            "name" => $packageName,
            "title" => $themeTitle,
            "description" => $description,
            "license" => $license,
            "version" => $version,
            "authors" => [
                [
                    "name" => $author,
                    "email" => $email
                ]
            ]
        ];

        $filesystem->dumpFile("$themeDir/composer.json",
            json_encode($composerJson, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        $output->writeln("Theme $packageName generated successfully.");

        return Command::SUCCESS;
    }
}
