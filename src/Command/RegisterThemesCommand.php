<?php

namespace App\Command;

use App\Service\ThemeDiscoveryService;
use App\Service\ThemeManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:register-themes')]
class RegisterThemesCommand extends Command
{
    private ThemeDiscoveryService $themeDiscoveryService;
    private ThemeManager $themeManager;

    public function __construct(ThemeDiscoveryService $themeDiscoveryService, ThemeManager $themeManager)
    {
        $this->themeDiscoveryService = $themeDiscoveryService;
        $this->themeManager = $themeManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Scans and registers available themes.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $themes = $this->themeDiscoveryService->discoverThemes();
        $registeredThemesCount = 0;

        foreach ($themes as $theme) {
            if (!$this->themeManager->findThemeByName($theme->getName())) {
                $parentTheme = null;
                if ($theme->getParentTheme()) {
                    $parentTheme = $this->themeManager->findThemeByName($theme->getParentTheme()->getName());
                }

                $this->themeManager->createTheme($theme, $parentTheme);
                $registeredThemesCount++;
            }
        }

        $output->writeln($registeredThemesCount . " themes registered successfully.");

        return Command::SUCCESS;
    }
}