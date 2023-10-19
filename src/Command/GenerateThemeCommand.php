<?php
declare(strict_types=1);

namespace App\Command;

use App\Event\ThemeGeneratedEvent;
use App\Service\GenerateThemeCommandQuestionsProvider;
use App\Service\ThemeFilesystemService;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Validator\GenerateThemeCommandValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsCommand(name: 'app:generate-theme')]
class GenerateThemeCommand extends Command
{
    private GenerateThemeCommandValidator $validator;
    private EventDispatcherInterface $dispatcher;
    private ThemeFilesystemService $themeFilesystemService;

    public function __construct(GenerateThemeCommandValidator $validator, EventDispatcherInterface $dispatcher, ThemeFilesystemService $themeFilesystemService)
    {
        $this->validator = $validator;
        $this->dispatcher = $dispatcher;
        $this->themeFilesystemService = $themeFilesystemService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Generates a new theme folder.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $answers = $this->askQuestions($input, $output);

        $this->createTheme($answers, $output);

        return Command::SUCCESS;
    }

    private function askQuestions(InputInterface $input, OutputInterface $output): array
    {
        $helper = $this->getHelper('question');
        $questionProvider = new GenerateThemeCommandQuestionsProvider();
        $questions = $questionProvider->getQuestions();

        $answers = [];
        foreach ($questions as $key => $data) {
            if (!isset($data['multiple']) || !$data['multiple']) {
                $question = new Question($data['question']);
                $question->setValidator([$this->validator, $data['validator']]);
                $answers[$key] = $helper->ask($input, $output, $question);
            }
        }

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
            }
        }

        return $answers;
    }

    private function createTheme(array $answers, OutputInterface $output): void
    {
        $packageNameCompiled = strtolower(str_replace(' ', '-', $answers['packageName']));
        $themeDir = 'themes/' . $packageNameCompiled;

        $this->themeFilesystemService->createThemeDirectories($themeDir);

        $composerJson = [
            "name" => $answers['packageName'],
            "title" => $answers['title'],
            "description" => $answers['description'],
            "license" => $answers['license'],
            "version" => $answers['version'],
            "homepage" => $answers['homepage'],
            "authors" => $answers['authors'],
            "type" => "ai-cms-theme",
            "tags" => [],
        ];

        $this->themeFilesystemService->createComposerJsonFile($themeDir, $composerJson);

        $output->writeln("Theme " . $answers['packageName'] . " generated successfully.");

        $event = new ThemeGeneratedEvent($answers['packageName']);
        $this->dispatcher->dispatch($event);
    }
}
