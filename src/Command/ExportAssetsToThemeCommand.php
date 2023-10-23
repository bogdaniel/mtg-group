<?php

namespace App\Command;

use App\Service\AssetManager;
use App\Service\ThemeManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:export-assets-to-active-theme')]
class ExportAssetsToThemeCommand extends Command
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
<?php

namespace App\Command;

use App\Service\AssetManager;
use App\Service\ThemeManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportAssetsFromThemeCommand extends Command
{
    protected static $defaultName = 'app:export-assets-from-theme';

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
            ->setHelp('This command allows you to export assets from the current active theme to the root directory...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $activeThemeName = $this->themeManager->getActiveThemeName();
        if ($activeThemeName) {
            $this->assetManager->copyAssetsToActiveTheme($activeThemeName);
            $output->writeln('Assets exported successfully from the active theme.');

            return Command::SUCCESS;
        }

        $output->writeln('No active theme found.');

        return Command::FAILURE;
    }
}
