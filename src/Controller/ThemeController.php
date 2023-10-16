<?php

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
    public function switchTheme($themeId): Response
    {
        $this->themeManager->setActiveTheme($themeId);

        return $this->redirectToRoute('themes');
    }

    #[Route("/theme/deactivate/{themeId}", name: "theme_deactivate")]
    public function deactivateTheme($themeId): Response
    {
        $this->themeManager->deactivateTheme($themeId);

        return $this->redirectToRoute('themes');
    }

    #[Route("/theme/install/{themeId}", name: "theme_install")]
    public function installAssets($themeId): Response
    {
        $theme = $this->themeManager->findThemeById($themeId);
        if ($theme) {
            // logic to install theme assets...
        }

        return $this->redirectToRoute('themes');
    }

    #[Route("/themes", name: "themes")]
    public function listThemes(): Response
    {
        $themes = $this->themeManager->findAllThemes();

        return $this->render('themes.html.twig', ['themes' => $themes]);
    }
}
