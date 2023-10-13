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
        $question->setValidator(function ($answer) {
            if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*\/[a-z0-9]+(?:-[a-z0-9]+)*$/', $answer)) {
                throw new \RuntimeException('The package name should be a valid composer package name.');
            }

            return strtolower($answer);
        });
        $packageName = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the description of the theme: ');
        $description = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the license of the theme: ');
        $license = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the homepage of the theme: ');
        $homepage = $helper->ask($input, $output, $question);

        $authors = [];
        while (true) {
            $question = new Question('Please enter the author of the theme (leave empty to stop): ');
            $authorName = ucwords($helper->ask($input, $output, $question));
            if (empty($authorName)) {
                break;
            }

            $question = new Question('Please enter the email of the author: ');
            $question->setValidator(function ($answer) {
                if (!filter_var($answer, FILTER_VALIDATE_EMAIL)) {
                    throw new \RuntimeException('The email should be a valid email address.');
                }

                return $answer;
            });
            $email = $helper->ask($input, $output, $question);

            $authors[] = ['name' => $authorName, 'email' => $email];
        }

        $question = new Question('Please enter the version of the theme: ');
        $question->setValidator(function ($answer) {
            if (!preg_match('/^(\d+\.)?(\d+\.)?(\*|\d+)$/', $answer)) {
                throw new \RuntimeException('The version should follow semantic versioning.');
            }

            return $answer;
        });
        $version = $helper->ask($input, $output, $question);

        $filesystem = new Filesystem();

        $packageNameCompiled = strtolower(str_replace(' ', '-', $packageName));

        $themeDir = 'themes/' . $packageNameCompiled;

        if (!$filesystem->exists($themeDir)) {
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
                "homepage" => $homepage,
                "authors" => $authors
            ];

            $filesystem->dumpFile("$themeDir/composer.json",
                json_encode($composerJson, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            );

            $output->writeln("Theme $packageName generated successfully.");
        } else {
            $output->writeln("Theme $packageName already exists.");
        }

        return Command::SUCCESS;
    }
}
