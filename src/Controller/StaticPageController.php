<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class StaticPageController extends AbstractController
{
    private \Twig\Loader\LoaderInterface $loader;

    public function __construct(Environment $twig)
    {
        $this->loader = $twig->getLoader();
    }

    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->redirectToRoute('static_page', ['pageName' => 'home']);
    }

    #[Route("/{pageName}/p", name: "static_page", defaults: ["pageName" => "home"])]
    public function loadPage(string $pageName = 'home'): Response
    {
        $multiGamaGroupMenu = [
            [
                'name' => 'Acasa',
                'path' => '/',
            ],
            [
                'name' => 'Despre Noi',
                'path' => '/about-us/p'
            ],
            [
                'name' => 'Produse',
                'path' => '/products/p'
            ],
            [
                'name' => 'Servicii',
                'path' => '/services/p',
                'sub_menu' => [
                    [
                        'name' => 'Servicii',
                        'path' => '/services/p',
                    ],
                    [
                        'name' => 'Detalii Serviciu',
                        'path' => '/services-details/p',
                    ]
                ]
            ],
            [
                'name' => 'Proiecte',
                'path' => '/portfolio/p'
            ],
            [
                'name' => 'Contact',
                'path' => '/contact-us/p'
            ],
        ];
        $slideshow = [
            [
                'header' => 'Mentenanță preventivă, <br/> predictivă și corectivă',
                'subheader' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi blandit eros euismod, efficitur odio vitae, pharetra sapien.',
                'picture' => 'picture-1.jpg',
            ],
            [
                'header' => 'Solutii Industriale <br/>Pentru Afacerea Ta',
                'subheader' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi blandit eros euismod, efficitur odio vitae, pharetra sapien.',
                'picture' => 'picture-2.jpg',
            ],
            [
                'header' => 'Servicii de mentenanță',
                'subheader' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi blandit eros euismod, efficitur odio vitae, pharetra sapien.',
                'picture' => 'picture-3.jpg',
            ],
        ];
        $aboutHeader = "Povestea Noastra!";
        $about = "Cu o activitate de peste 32 de ani, Multigama Grup,alcătuită din firmele SC Multigama Tech SRL, SC Multigama Service SRL și EQ Fire SRL asigură clienților
săi atât pe piața internă cât și pe cea internațională echipamente noi performante, piese de schimb și mentenanță la cele mai înalte standarde pentru pompe,
grupuril de pompare, stații de pompare și echipamentele de stingere a incendiilor.";
        $quickContactHeader = "MULTIGAMA GROUP";
        $quickContactContent = "Povestea grupului Multigama a început cu firma Multigama Industrial, înființată la 4 decembrie 1990 de un grup de ingineri, foști angajați ai companiei AVERSA, specializați în domeniul pompelor. Principalul obiectiv a fost de a vinde și produce pompe pentru uz casnic care nu existau pe piața românească de la acea vreme.
                        Primul proiect realizat de Multigama Industrial a fost reabilitarea echipamentului de pompare de la Casa Enescu, în anul 1991.
";
        $skinVersion = 'skin_3';
        $logo = 'logo-multigama-group.png';

        if (str_contains($pageName, 'multigama-tech-')) {
            $multiGamaGroupMenu = [
                [
                    'name' => 'Acasa',
                    'path' => '/',
                ],
                [
                    'name' => 'Despre Noi',
                    'path' => '/multigama-tech-about-us/p'
                ],
                [
                    'name' => 'Produse',
                    'path' => '/multigama-tech-products/p'
                ],
                [
                    'name' => 'Servicii',
                    'path' => '/multigama-tech-services/p',
                    'sub_menu' => [
                        [
                            'name' => 'Servicii',
                            'path' => '/multigama-tech-services/p',
                        ],
                        [
                            'name' => 'Detalii Serviciu',
                            'path' => '/multigama-tech-services-details/p',
                        ]
                    ]
                ],
                [
                    'name' => 'Proiecte',
                    'path' => '/multigama-tech-portfolio/p'
                ],
                [
                    'name' => 'Contact',
                    'path' => '/multigama-tech-contact-us/p'
                ],
            ];

            $slideshow = [
                [
                    'header' => 'Mentenanță preventivă, <br/> predictivă și corectivă',
                    'subheader' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi blandit eros euismod, efficitur odio vitae, pharetra sapien.',
                    'picture' => 'slide1.png',
                ],
                [
                    'header' => 'Solutii Industriale <br/>Pentru Afacerea Ta',
                    'subheader' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi blandit eros euismod, efficitur odio vitae, pharetra sapien.',
                    'picture' => 'slide2.jpg',
                ],
                [
                    'header' => 'Servicii de mentenanță',
                    'subheader' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi blandit eros euismod, efficitur odio vitae, pharetra sapien.',
                    'picture' => 'slide3.jpg',
                ],
            ];
            $aboutHeader = "Lucram cu tine pentru a gasi solutii impreuna!";
            $about = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
            $quickContactHeader = "MULTIGAMA TECH";
            $quickContactContent = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

            $logo = 'multigama-tech.png';
        }

        if (str_contains($pageName, 'multigama-service-')) {
            $multiGamaGroupMenu = [
                [
                    'name' => 'Acasa',
                    'path' => '/',
                ],
                [
                    'name' => 'Despre Noi',
                    'path' => '/multigama-service-about-us/p'
                ],
                [
                    'name' => 'Produse',
                    'path' => '/multigama-service-products/p'
                ],
                [
                    'name' => 'Servicii',
                    'path' => '/multigama-service-services/p',
                    'sub_menu' => [
                        [
                            'name' => 'Servicii',
                            'path' => '/multigama-service-services/p',
                        ],
                        [
                            'name' => 'Detalii Serviciu',
                            'path' => '/multigama-service-services-details/p',
                        ]
                    ]
                ],
                [
                    'name' => 'Proiecte',
                    'path' => '/multigama-service-portfolio/p'
                ],
                [
                    'name' => 'Contact',
                    'path' => '/multigama-service-contact-us/p'
                ],
            ];

            $slideshow = [
                [
                    'header' => 'Mentenanță preventivă, <br/> predictivă și corectivă',
                    'subheader' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi blandit eros euismod, efficitur odio vitae, pharetra sapien.',
                    'picture' => 'slide1.png',
                ],
                [
                    'header' => 'Solutii Industriale <br/>Pentru Afacerea Ta',
                    'subheader' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi blandit eros euismod, efficitur odio vitae, pharetra sapien.',
                    'picture' => 'slide2.jpg',
                ],
                [
                    'header' => 'Servicii de mentenanță',
                    'subheader' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi blandit eros euismod, efficitur odio vitae, pharetra sapien.',
                    'picture' => 'slide3.jpg',
                ],
            ];
            $aboutHeader = "Lucram cu tine pentru a gasi solutii impreuna!";
            $about = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
            $quickContactHeader = "MULTIGAMA SERVICE";
            $quickContactContent = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

            $logo = 'multigama-service.png';
                    $skinVersion = 'skin_4';
        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            $multiGamaGroupMenu = [
                [
                    'name' => 'Acasa',
                    'path' => '/',
                ],
                [
                    'name' => 'Despre Noi',
                    'path' => '/multigama-eq-fire--about-us/p'
                ],
                [
                    'name' => 'Produse',
                    'path' => '/multigama-eq-fire--products/p'
                ],
                [
                    'name' => 'Servicii',
                    'path' => '/multigama-eq-fire--services/p',
                    'sub_menu' => [
                        [
                            'name' => 'Servicii',
                            'path' => '/multigama-eq-fire--services/p',
                        ],
                        [
                            'name' => 'Detalii Serviciu',
                            'path' => '/multigama-eq-fire--services-details/p',
                        ]
                    ]
                ],
                [
                    'name' => 'Proiecte',
                    'path' => '/multigama-eq-fire--portfolio/p'
                ],
                [
                    'name' => 'Contact',
                    'path' => '/multigama-eq-fire--contact-us/p'
                ],
            ];

            $slideshow = [
                [
                    'header' => 'Mentenanță preventivă, <br/> predictivă și corectivă',
                    'subheader' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi blandit eros euismod, efficitur odio vitae, pharetra sapien.',
                    'picture' => 'slide1.png',
                ],
                [
                    'header' => 'Solutii Industriale <br/>Pentru Afacerea Ta',
                    'subheader' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi blandit eros euismod, efficitur odio vitae, pharetra sapien.',
                    'picture' => 'slide2.jpg',
                ],
                [
                    'header' => 'Servicii de mentenanță',
                    'subheader' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi blandit eros euismod, efficitur odio vitae, pharetra sapien.',
                    'picture' => 'slide3.jpg',
                ],
            ];
            $aboutHeader = "Lucram cu tine pentru a gasi solutii impreuna!";
            $about = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
            $quickContactHeader = "MULTIGAMA SERVICE";
            $quickContactContent = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

            $logo = 'multigama-service.png';
            $skinVersion = 'skin_1';
        }
        return $this->render("templates/pages/{$pageName}.html.twig", [
            'multiGamaGroupMenu' => $multiGamaGroupMenu,
            'skinVersion' => $skinVersion,
            'logo' => $logo,
            'slideshow' => $slideshow,
            'about' => $about,
            'aboutHeader' => $aboutHeader,
            'quickContactHeader' => $quickContactHeader,
            'quickContactContent' => $quickContactContent,
        ]);
    }
}
