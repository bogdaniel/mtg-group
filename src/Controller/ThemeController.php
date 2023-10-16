<?php

namespace App\Controller;

use App\Service\ThemeManager;
use App\Service\ThemeRuntimeConfigurator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThemeController extends AbstractController
{
    private ThemeManager $themeManager;
    private ThemeRuntimeConfigurator $themeRuntimeConfigurator;

    public function __construct(ThemeManager $themeManager, ThemeRuntimeConfigurator $themeRuntimeConfigurator)
    {
        $this->themeManager = $themeManager;
        $this->themeRuntimeConfigurator = $themeRuntimeConfigurator;
    }

    #[Route("/theme/switch/{themeId}", name: "theme_switch")]
    public function switchTheme($themeId): Response
    {
        $this->themeManager->setActiveTheme($themeId);
        $this->themeRuntimeConfigurator->configure();

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
        $activeTheme = $this->themeManager->findThemeById($this->themeManager->getActiveThemeId());
        $activeThemeName = $this->themeManager->getActiveThemeName();

        return $this->render(
            $activeThemeName . '/templates/admin/theme_manager/themes.html.twig',
            ['themes' => $themes, 'activeTheme' => $activeTheme, 'activeThemeName' => $activeThemeName]
        );
    }
}
