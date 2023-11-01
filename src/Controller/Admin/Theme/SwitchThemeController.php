<?php
declare(strict_types=1);

namespace App\Controller\Admin\Theme;

use App\Service\ThemeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SwitchThemeController extends AbstractController
{
    private ThemeManager $themeManager;
    public function __construct(ThemeManager $themeManager)
    {
        $this->themeManager = $themeManager;
    }

    #[Route("/theme/switch/{themeId}", name: "theme_switch")]
    public function __invoke(int $themeId): Response
    {
        $this->themeManager->setActiveTheme($themeId);

        return $this->redirectToRoute('themes');
    }
}
