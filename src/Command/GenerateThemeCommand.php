<?php

namespace App\Command;

use App\Validator\ThemeValidator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(name: 'app:generate-theme')]
class GenerateThemeCommand extends Command
{
    private ThemeValidator $validator;

    public function __construct(ThemeValidator $validator)
    {
        $this->validator = $validator;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Generates a new theme folder.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $question = new Question('Please enter the title of the theme: ');
        $question->setValidator([$this->validator, 'validateTitle']);
        $themeTitle = ucwords($helper->ask($input, $output, $question));

        $question = new Question('Please enter the package name of the theme: ');
        $question->setValidator([$this->validator, 'validatePackageName']);
        $packageName = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the description of the theme: ');
        $question->setValidator([$this->validator, 'validateDescription']);
        $description = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the license of the theme: ');
        $question->setValidator([$this->validator, 'validateLicense']);
        $license = $helper->ask($input, $output, $question);

        $question = new Question('Please enter the homepage of the theme: ');
        $question->setValidator([$this->validator, 'validateHomepage']);
        $homepage = $helper->ask($input, $output, $question);

        $authors = [];
        while (true) {
            $question = new Question('Please enter the author of the theme (leave empty to stop): ');
            $authorName = ucwords($helper->ask($input, $output, $question));
            if (empty($authorName)) {
                break;
            }

            $question = new Question('Please enter the email of the author: ');
            $question->setValidator([$this->validator, 'validateAuthorEmail']);
            $email = $helper->ask($input, $output, $question);

            $authors[] = ['name' => $authorName, 'email' => $email];
        }

        $question = new Question('Please enter the version of the theme: ');
        $question->setValidator([$this->validator, 'validateVersion']);
        $version = $helper->ask($input, $output, $question);

        $filesystem = new Filesystem();


        $array = explode('/', $packageName);
        $packageNameCompiled = strtolower(str_replace(' ', '-', array_pop($array)));
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
