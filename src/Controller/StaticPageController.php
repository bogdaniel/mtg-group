<?php

namespace App\Controller;

use App\Service\ThemeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticPageController extends AbstractController
{
    private $themeService;

    public function __construct(ThemeService $themeService)
    {
        $this->themeService = $themeService;
    }

    /**
     * @Route("/page/{pageName}", name="static_page")
     */
    public function loadPage(string $pageName): Response
    {
        $content = $this->themeService->loadStaticPage($pageName);

        return new Response($content);
    }
}
