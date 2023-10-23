<?php

namespace App\Command;

use App\Service\AssetManager;
use App\Service\ThemeManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CopyAssetsCommand extends Command
{
    protected static $defaultName = 'app:copy-assets';

    private AssetManager $assetManager;
    private ThemeManager $themeManager;

    public function __construct(AssetManager $assetManager, ThemeManager $themeManager)
    {
        $this->assetManager = $assetManager;
        $this->themeManager = $themeManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Copies assets from the root directory to the current active theme.')
            ->setHelp('This command allows you to copy assets from the root directory to the current active theme...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $activeThemeName = $this->themeManager->getActiveThemeName();

        if ($activeThemeName) {
            $this->assetManager->copyAssetsToActiveTheme($activeThemeName);
            $output->writeln('Assets copied successfully to the active theme.');

            return Command::SUCCESS;
        }

        $output->writeln('No active theme found.');

        return Command::FAILURE;
    }
}
