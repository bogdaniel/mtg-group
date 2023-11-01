<?php
declare(strict_types=1);

namespace App\Controller\Admin\Theme;

use App\Service\ThemeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeactivateThemeController extends AbstractController
{
    private ThemeManager $themeManager;
    public function __construct(ThemeManager $themeManager)
    {
        $this->themeManager = $themeManager;
    }

    #[Route("/theme/deactivate/{themeId}", name: "theme_deactivate")]
    public function __invoke(int $themeId): Response
    {
        $this->themeManager->deactivateTheme($themeId);

        return $this->redirectToRoute('themes');
    }
}
