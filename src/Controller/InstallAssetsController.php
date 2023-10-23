<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ThemeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstallAssetsController extends AbstractController
{
    private ThemeManager $themeManager;
    private string $projectDir;

    public function __construct(ThemeManager $themeManager, string $projectDir)
    {
        $this->themeManager = $themeManager;
        $this->projectDir = $projectDir;
    }

    #[Route("/theme/install/{themeId}", name: "theme_install")]
    public function __invoke(int $themeId): Response
    {
        $theme = $this->themeManager->findThemeById($themeId);
        if ($theme) {
            // logic to install theme assets...
            $this->copyThemeAssetsToProjectRoot($theme);
        }

        return $this->redirectToRoute('themes');
    }

    private function copyThemeAssetsToProjectRoot(Theme $theme): void
    {
        $themeDir = $this->projectDir . '/themes/' . $theme->getId();
        $filesToCopy = ['package.json', 'webpack.config.js'];

        foreach ($filesToCopy as $file) {
            if (file_exists($themeDir . '/' . $file)) {
                copy($themeDir . '/' . $file, $this->projectDir . '/' . $file);
            }
        }
    }
}
