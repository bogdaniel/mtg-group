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
                'path' => '/page/about-us'
            ],
            [
                'name' => 'Produse',
                'path' => '/page/products'
            ],
            [
                'name' => 'Servicii',
                'path' => '/page/services/',
                'sub_menu' => [
                    [
                        'name' => 'Servicii',
                        'path' => '/page/services/',
                    ],
                    [
                        'name' => 'Detalii Serviciu',
                        'path' => '/page/services-details/',
                    ]
                ]
            ],
            [
                'name' => 'Proiecte',
                'path' => '/page/portfolio'
            ],
            [
                'name' => 'Contact',
                'path' => '/page/contact-us'
            ],
        ];

        $skinVersion = 'skin-3.css';
        return $this->render("templates/pages/{$pageName}.html.twig", [
            'multiGamaGroupMenu' => $multiGamaGroupMenu,
            'skinVersion' => $skinVersion
        ]);
    }
}
