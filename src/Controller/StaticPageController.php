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
                'name' => 'Mutligama Group',
                'path' => '/',
                'sub_menu' => [
                    [
                        'name' => 'MultiGama Tech',
                        'path' => '/multigama-tech-home/p',
                    ],
                    [
                        'name' => 'Multigama Service',
                        'path' => '/multigama-service-home/p',
                    ],
                    [
                        'name' => 'EQ Fire',
                        'path' => '/multigama-eq-fire-home/p',
                    ],

                ],
            ],

            [
                'name' => 'Companie',
                'path' => '/about-us/p',
                'sub_menu' => [
                    [
                        'name' => 'Misiune',
                        'path' => '/about-us/p',
                    ],
                    [
                        'name' => 'Viziune',
                        'path' => '/company-vision/p',
                    ],
                ],
            ],
//            [
//                'name' => 'Produse',
//                'path' => '/products/p'
//            ],
            [
                'name' => 'Servicii',
                'path' => '/services/p',
//                'sub_menu' => [
//                    [
//                        'name' => 'Servicii',
//                        'path' => '/services/p',
//                    ],
//                    [
//                        'name' => 'Detalii Serviciu',
//                        'path' => '/services-details/p',
//                    ]
//                ]
            ],
            [
                'name' => 'Proiecte',
                'path' => '/portfolio/p',
            ],
            [
                'name' => 'Contact',
                'path' => '/contact-us/p',
            ],
        ];
        $slideshow = [
            [
                'header' => 'Mentenanță preventivă, <br/> predictivă și corectivă',
                'subheader' => '',
                'picture' => 'number-electric-motors-with-reducers-tanks-mixing-liquids-food-industry.jpg',
            ],
            [
                'header' => 'Solutii Industriale <br/>Pentru Afacerea Ta',
                'subheader' => '',
                'picture' => 'steel-pipelines-cables-plant.jpg',
            ],
            [
                'header' => 'Servicii de mentenanță',
                'subheader' => '',
                'picture' => 'pump-pipe-line-oil-pressure-gauge-valves-plant-pressure-safety-valve-selective.jpg',
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
                    'name' => 'MultiGama Tech',
                    'path' => '/',
                    'sub_menu' => [
                        [
                            'name' => 'MultiGama Group',
                            'path' => '/',
                        ],
                        [
                            'name' => 'Multigama Service',
                            'path' => '/multigama-service-home/p',
                        ],
                        [
                            'name' => 'EQ Fire',
                            'path' => '/multigama-eq-fire-home/p',
                        ],

                    ],
                ],
                [
                    'name' => 'Despre Noi',
                    'path' => '/multigama-tech-about-us/p',
                ],
//                [
//                    'name' => 'Produse',
//                    'path' => '/multigama-tech-products/p'
//                ],
                [
                    'name' => 'Servicii',
                    'path' => '/multigama-tech-services/p',
//                    'sub_menu' => [
//                        [
//                            'name' => 'Servicii',
//                            'path' => '/multigama-tech-services/p',
//                        ],
//                        [
//                            'name' => 'Detalii Serviciu',
//                            'path' => '/multigama-tech-services-details/p',
//                        ]
//                    ]
                ],
                [
                    'name' => 'Proiecte',
                    'path' => '/multigama-tech-portfolio/p',
                ],
                [
                    'name' => 'Contact',
                    'path' => '/multigama-tech-contact-us/p',
                ],
            ];

            $slideshow = [
                [
                    'header' => 'Mentenanță preventivă, <br/> predictivă și corectivă',
                    'subheader' => '',
                    'picture' => 'slide1.png',
                ],
                [
                    'header' => 'Solutii Industriale <br/>Pentru Afacerea Ta',
                    'subheader' => '',
                    'picture' => 'slide2.jpg',
                ],
                [
                    'header' => 'Servicii de mentenanță',
                    'subheader' => '',
                    'picture' => 'slide3.jpg',
                ],
            ];
            $aboutHeader = "Lucram cu tine pentru a gasi solutii impreuna!";
            $about = "Cu o experiență vastă și o dedicare neclintită față de excelență, Multigama Tech se află în fruntea industriei de vânzare a pompelor industriale. Suntem pasionați de furnizarea soluțiilor ideale pentru nevoile de transport și gestionare a fluidelor în industrie.

Specializați în furnizarea unei game complete de pompe industriale, de la cele de uz general până la cele specializate pentru aplicații specifice, ne străduim să aducem inovație și performanță fiecărui partener industrial.

";
            $quickContactHeader = "MULTIGAMA TECH";
            $quickContactContent = "";

            $logo = 'multigama-tech.png';
        }

        if (str_contains($pageName, 'multigama-service-')) {
            $multiGamaGroupMenu = [
                [
                    'name' => 'Mutligama Service',
                    'path' => '/',
                    'sub_menu' => [
                        [
                            'name' => 'MultiGama Group',
                            'path' => '/',
                        ],
                        [
                            'name' => 'Multigama Service',
                            'path' => '/multigama-service-home/p',
                        ],
                        [
                            'name' => 'EQ Fire',
                            'path' => '/multigama-eq-fire-home/p',
                        ],

                    ],
                ],
                [
                    'name' => 'Despre Noi',
                    'path' => '/multigama-service-about-us/p',
                ],
//                [
//                    'name' => 'Produse',
//                    'path' => '/multigama-service-products/p'
//                ],
                [
                    'name' => 'Servicii',
                    'path' => '/multigama-service-services/p',
                ],
                [
                    'name' => 'Proiecte',
                    'path' => '/multigama-service-portfolio/p',
                ],
                [
                    'name' => 'Contact',
                    'path' => '/multigama-service-contact-us/p',
                ],
            ];

            $slideshow = [
                [
                    'header' => 'Mentenanță preventivă, <br/> predictivă și corectivă',
                    'subheader' => '',
                    'picture' => 'slide1.png',
                ],
                [
                    'header' => 'Solutii Industriale <br/>Pentru Afacerea Ta',
                    'subheader' => '',
                    'picture' => 'slide2.jpg',
                ],
                [
                    'header' => 'Servicii de mentenanță',
                    'subheader' => '',
                    'picture' => 'slide3.jpg',
                ],
            ];
            $aboutHeader = "Expertiza Multigama Service în Soluții Complete pentru Pompe Industriale!";
            $about = "Multigama Service este un lider de necontestat în domeniul întreținerii, reparației și
                                oferirii de soluții complete pentru pompele industriale. Cu o echipă experimentată și o
                                abordare dedicată, ne angajăm să aducem performanță și fiabilitate în universul
                                transportului și manipulării fluidelor în industrie.";
            $quickContactHeader = "MULTIGAMA SERVICE";
            $quickContactContent = "";

            $logo = 'multigama-service.png';
            $skinVersion = 'skin_4';
        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            $multiGamaGroupMenu = [
                [
                    'name' => 'EQ Fire',
                    'path' => '/',
                    'sub_menu' => [
                        [
                            'name' => 'MultiGama Group',
                            'path' => '/',
                        ],
                        [
                            'name' => 'Multigama Service',
                            'path' => '/multigama-service-home/p',
                        ],
                        [
                            'name' => 'EQ Fire',
                            'path' => '/multigama-eq-fire-home/p',
                        ],

                    ],
                ],
                [
                    'name' => 'Despre Noi',
                    'path' => '/multigama-eq-fire-about-us/p',
                ],
                [
                    'name' => 'Produse',
                    'path' => '/multigama-eq-fire-products/p',
                ],
                [
                    'name' => 'Servicii',
                    'path' => '/multigama-eq-fire-services/p',
                    'sub_menu' => [
                        [
                            'name' => 'Servicii',
                            'path' => '/multigama-eq-fire-services/p',
                        ],
                        [
                            'name' => 'Detalii Serviciu',
                            'path' => '/multigama-eq-fire-services-details/p',
                        ],
                    ],
                ],
                [
                    'name' => 'Proiecte',
                    'path' => '/multigama-eq-fire-portfolio/p',
                ],
                [
                    'name' => 'Contact',
                    'path' => '/multigama-eq-fire-contact-us/p',
                ],
            ];

            $slideshow = [
                [
                    'header' => 'Mentenanță preventivă, <br/> predictivă și corectivă',
                    'subheader' => '',
                    'picture' => 'slide1.png',
                ],
                [
                    'header' => 'Solutii Industriale <br/>Pentru Afacerea Ta',
                    'subheader' => '',
                    'picture' => 'slide2.jpg',
                ],
                [
                    'header' => 'Servicii de mentenanță',
                    'subheader' => '',
                    'picture' => 'slide3.jpg',
                ],
            ];
            $aboutHeader = "Siguranță de Încredere cu EQ Fire pentru Sisteme de Stingere a Incendiilor";
            $about = "EQ Fire se remarcă ca lider de încredere în furnizarea și întreținerea sistemelor de stingere a incendiilor pentru mediul industrial. Ne angajăm să asigurăm protecția optimă împotriva incendiilor în facilitățile industriale, oferind soluții inovatoare și servicii de cea mai înaltă calitate.

";
            $quickContactHeader = "MULTIGAMA SERVICE";
            $quickContactContent = "";

            $logo = 'eq-fire.png';
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
