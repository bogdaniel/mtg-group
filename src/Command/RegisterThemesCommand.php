<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\ThemeDiscoveryService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:register-themes')]
class RegisterThemesCommand extends Command
{
    private ThemeDiscoveryService $themeDiscoveryService;

    public function __construct(ThemeDiscoveryService $themeDiscoveryService)
    {
        $this->themeDiscoveryService = $themeDiscoveryService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Scans and registers available themes.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $registeredThemesCount = $this->themeDiscoveryService->discoverThemes();

        if ([] === $registeredThemesCount) {
            $output->writeln('No new themes found to register.');

            return Command::SUCCESS;
        }

        $output->writeln(count($registeredThemesCount) . " themes registered successfully.");

        return Command::SUCCESS;
    }
}
