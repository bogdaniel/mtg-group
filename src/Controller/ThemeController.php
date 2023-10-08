<?php

namespace App\Controller;

use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThemeController extends AbstractController
{
    #[Route("/theme/switch/{themeId}", name: "theme_switch")]
    public function switchTheme($themeId, ThemeRepository $themeRepository): Response
    {
        $themeRepository->setActive($themeId);

        return $this->redirectToRoute('dashboard');
    }

    #[Route("/theme/install/{themeId}", name: "theme_install")]
    public function installAssets($themeId, ThemeRepository $themeRepository): Response
    {
        $theme = $themeRepository->find($themeId);
        if ($theme) {
            // logic to install theme assets...
        }

        return $this->redirectToRoute('dashboard');
    }

    #[Route("/dashboard", name: "dashboard")]
    public function dashboard(): Response
    {
        // logic to display dashboard...

        return $this->render('dashboard.html.twig');
    }

    #[Route("/themes", name: "themes")]
    public function listThemes(ThemeRepository $themeRepository): Response
    {
        $themes = $themeRepository->findAll();

        return $this->render('themes.html.twig', ['themes' => $themes]);
    }
}
