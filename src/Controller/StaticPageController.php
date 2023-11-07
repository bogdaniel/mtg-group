<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticPageController extends AbstractController
{
    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->redirectToRoute('static_page', ['pageName' => 'home']);
    }

    #[Route("/page/{pageName}", name: "static_page", defaults: ["pageName" => "home"])]
    public function loadPage(string $pageName = 'home'): Response
    {
        $multiGamaGroupMenu = [
            [
                'name' => 'Acasa',
                'path' => '/',
            ],
            [
                'name' => 'Despre Noi',
                'path' => 'pages/about-us'
            ],
            [
                'name' => 'Produse',
                'path' => '/pages/products'
            ],
            [
                'name' => 'Servicii',
                'path' => '/pages/services/'
            ],
            [
                'name' => '',
                'path' => '/'
            ],
            [
                'name' => 'Proiecte',
                'path' => '/pages/projects'
            ],
            [
                'name' => 'Contact',
                'path' => '/pages/contact'
            ],
        ];
        return $this->render("templates/pages/{$pageName}.html.twig", [
            'multiGamaGroupMenu' => $multiGamaGroupMenu
        ]);
    }
}
