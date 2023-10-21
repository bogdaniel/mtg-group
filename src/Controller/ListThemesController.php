<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ThemeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListThemesController extends AbstractController
{
    private ThemeManager $themeManager;
    public function __construct(ThemeManager $themeManager)
    {
        $this->themeManager = $themeManager;
    }

    #[Route("/themes", name: "themes")]
    public function listThemes(): Response
    {
        $themes = $this->themeManager->findAllThemes();
        $activeTheme = $this->themeManager->findThemeById($this->themeManager->getActiveThemeId());
        $activeThemeName = $this->themeManager->getActiveThemeName();

        return $this->render('@zenchron:default-theme/templates/admin/theme_manager/themes.html.twig',
            ['themes' => $themes, 'activeTheme' => $activeTheme, 'activeThemeName' => $activeThemeName]
        );
    }
}
