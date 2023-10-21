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
    public function __construct(ThemeManager $themeManager)
    {
        $this->themeManager = $themeManager;
    }

    #[Route("/theme/install/{themeId}", name: "theme_install")]
    public function installAssets(int $themeId): Response
    {
        $theme = $this->themeManager->findThemeById($themeId);
        if ($theme) {
            // logic to install theme assets...
        }

        return $this->redirectToRoute('themes');
    }
}
