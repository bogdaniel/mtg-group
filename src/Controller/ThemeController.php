<?php

namespace App\Controller;

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
}
