<?php

namespace App\Command;

use App\Domain\Entity\ThemeData;
use App\Service\AssetManager;
use App\Service\ThemeManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:export-assets-from-active-theme')]
class ExportAssetsFromThemeCommand extends Command
{
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
            ->setDescription('Exports assets from the current active theme to the root directory.')
            ->setHelp(
                'This command allows you to export assets from the current active theme to the root directory...'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $activeThemeId = $this->themeManager->getActiveThemeId();
        $theme = $this->themeManager->findThemeById($activeThemeId);

        if ([] === $theme) {
            $output->writeln('No active theme found.');
            return Command::FAILURE;
        }

        $themeData = ThemeData::createFromEntity($theme);
        $this->assetManager->copyThemeAssetsToProjectRoot($themeData);
        $output->writeln('Assets exported successfully from the active theme.');

        return Command::SUCCESS;


    }
}
