<?php

namespace App\Command;

use App\Event\ThemeGeneratedEvent;
use App\Service\GenerateThemeCommandQuestionsProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Validator\GenerateThemeCommandValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsCommand(name: 'app:generate-theme')]
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

        $questionProvider = new GenerateThemeCommandQuestionsProvider();
        $questions = $questionProvider->getQuestions();

        $answers = [];
        foreach ($questions as $key => $data) {
            if (isset($data['multiple']) && $data['multiple']) {
                $answers[$key] = [];
                while (true) {
                    $question = new Question($data['question']);
                    if ($data['validator']) {
                        $question->setValidator([$this->validator, $data['validator']]);
                    }
                    $answer = $helper->ask($input, $output, $question);
                    if (empty($answer)) {
                        break;
                    }
                    $subAnswers = ['name' => $answer];
                    foreach ($data['subQuestions'] as $subKey => $subData) {
                        $question = new Question($subData['question']);
                        $question->setValidator([$this->validator, $subData['validator']]);
                        $subAnswers[$subKey] = $helper->ask($input, $output, $question);
                    }
                    $answers[$key][] = $subAnswers;
                }
            } else {
                $question = new Question($data['question']);
                $question->setValidator([$this->validator, $data['validator']]);
                $answers[$key] = $helper->ask($input, $output, $question);
            }
        }

        $filesystemService = new FilesystemService();


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
