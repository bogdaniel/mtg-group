<?php

namespace App\Command;

use App\Event\ThemeGeneratedEvent;
use App\Validator\GenerateThemeCommandValidator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(name: 'app:generate-theme')]
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class GenerateThemeCommand extends Command
{
    private GenerateThemeCommandValidator $validator;
    private EventDispatcherInterface $dispatcher;

    public function __construct(GenerateThemeCommandValidator $validator, EventDispatcherInterface $dispatcher)
    {
        $this->validator = $validator;
        $this->dispatcher = $dispatcher;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Generates a new theme folder.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $questions = [
            'title' => [
                'question' => 'Please enter the title of the theme: ',
                'validator' => 'validateTitle',
            ],
            'packageName' => [
                'question' => 'Please enter the package name of the theme: ',
                'validator' => 'validatePackageName',
            ],
            'description' => [
                'question' => 'Please enter the description of the theme: ',
                'validator' => 'validateDescription',
            ],
            'license' => [
                'question' => 'Please enter the license of the theme: ',
                'validator' => 'validateLicense',
            ],
            'homepage' => [
                'question' => 'Please enter the homepage of the theme: ',
                'validator' => 'validateHomepage',
            ],
            'version' => [
                'question' => 'Please enter the version of the theme: ',
                'validator' => 'validateVersion',
            ],
        ];

        $answers = [];
        foreach ($questions as $key => $data) {
            $question = new Question($data['question']);
            $question->setValidator([$this->validator, $data['validator']]);
            $answers[$key] = $helper->ask($input, $output, $question);
        }

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

        $answers['authors'] = $authors;

        $filesystem = new Filesystem();


        $array = explode('/', $answers['packageName']);
        $packageNameCompiled = strtolower(str_replace(' ', '-', array_pop($array)));
        $themeDir = 'themes/' . $packageNameCompiled;

        if (!$filesystem->exists($themeDir)) {
            if (!$filesystem->exists($themeDir)) {
                $filesystem->mkdir([
                    $themeDir,
                    "$themeDir/public",
                    "$themeDir/templates",
                    "$themeDir/templates/bundles",
                    "$themeDir/translations",
                ]);

                $composerJson = [
                    "name" => $answers['packageName'],
                    "title" => $answers['title'],
                    "description" => $answers['description'],
                    "license" => $answers['license'],
                    "version" => $answers['version'],
                    "homepage" => $answers['homepage'],
                    "authors" => $answers['authors']
                ];

                $filesystem->dumpFile("$themeDir/composer.json",
                    json_encode($composerJson, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
                );

                $output->writeln("Theme " . $answers['packageName'] . " generated successfully.");

                $event = new ThemeGeneratedEvent($answers['packageName']);
                $this->dispatcher->dispatch($event);
            }
        } else {
            $output->writeln("Theme " . $answers['packageName'] . " already exists.");
        }

        return Command::SUCCESS;
    }
}
