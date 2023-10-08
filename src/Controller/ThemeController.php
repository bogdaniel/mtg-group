<?php

namespace App\Controller;

use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThemeController extends AbstractController
{
    #[Route("/theme/switch/{themeId}", name: "theme_switch")]
    public function switchTheme($themeId): Response
    {
        // logic to switch theme...

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
