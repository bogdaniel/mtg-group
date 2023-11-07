<?php

namespace App\Controller;

use App\Service\ThemeManager;
use App\Service\ThemeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class StaticPageController extends AbstractController
{
    private ThemeService $themeService;
    private ThemeManager $themeManager;

    public function __construct(ThemeService $themeService, ThemeManager $themeManager)
    {
        $this->themeService = $themeService;
        $this->themeManager = $themeManager;
    }

    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->redirectToRoute('static_page', ['pageName' => 'home']);
    }

    #[Route("/page/{pageName}", name: "static_page", defaults: ["pageName" => "home"])]
    public function loadPage(string $pageName = 'home'): Response
    {
        $activeTheme = $this->themeManager->getActiveTheme();
        $content = $this->themeService->loadStaticPage($activeTheme->name, $pageName);

        return new Response($content);
    }
}
