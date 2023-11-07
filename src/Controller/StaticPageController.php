<?php

namespace App\Controller;

use App\Service\ThemeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class StaticPageController extends AbstractController
{
    private ThemeService $themeService;

    public function __construct(ThemeService $themeService)
    {
        $this->themeService = $themeService;
    }

    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->redirectToRoute('static_page', ['pageName' => 'home']);
    }

    #[Route("/page/{pageName}", name: "static_page", defaults: ["pageName" => "home"])]
    public function loadPage(string $pageName = 'home'): Response
    {
        $activeTheme = $this->themeService->getActiveTheme();
        $content = $this->themeService->loadStaticPage($activeTheme, $pageName);

        return new Response($content);
    }
}
