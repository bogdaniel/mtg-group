<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ThemeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThemeController extends AbstractController
{
    private ThemeManager $themeManager;
    public function __construct(ThemeManager $themeManager)
    {
        $this->themeManager = $themeManager;
    }

    #[Route("/theme/switch/{themeId}", name: "theme_switch")]
    public function switchTheme(int $themeId): Response
    {
        $this->themeManager->setActiveTheme($themeId);

        return $this->redirectToRoute('themes');
    }

    #[Route("/theme/deactivate/{themeId}", name: "theme_deactivate")]
    public function deactivateTheme(int $themeId): Response
    {
        $this->themeManager->deactivateTheme($themeId);

        return $this->redirectToRoute('themes');
    }



    // The listThemes method has been moved to the ListThemesController
}
