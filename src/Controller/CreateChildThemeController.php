<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ThemeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateChildThemeController extends AbstractController
{
    private ThemeManager $themeManager;
    public function __construct(ThemeManager $themeManager)
    {
        $this->themeManager = $themeManager;
    }

    #[Route("/theme/create-child/{themeId}", name: "theme_create_child")]
    public function createChildTheme(int $themeId): Response
    {
        $this->themeManager->createChildTheme($themeId);

        return $this->redirectToRoute('themes');
    }
}
