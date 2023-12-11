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
        $logoList = [
            'multigama-tech' => [
                'logo' => 'multigama-tech.png',
                'preloaderLogo' => 'multigama-tech.png',
                'skinVersion' => 'skin_3',
            ],
            'multigama-service' => [
                'logo' => 'multigama-service.png',
                'preloaderLogo' => 'multigama-service.png',
                'skinVersion' => 'skin_4',
            ],
            'multigama-eq-fire' => [
                'logo' => 'eq-fire.png',
                'preloaderLogo' => 'eq-fire.png',
                'skinVersion' => 'skin_1',
            ],
        ];

        $contactEmail = 'office@multigama.ro';

        $items = [
            [
                'icon' => 'fa-arrow-up-from-water-pump', // Font Awesome icon class
                'title' => 'Multigama Tech',
                'description' => 'Cu o experiență vastă și o dedicare neclintită față de excelență, Multigama Tech se află în fruntea industriei de vânzare a pompelor industriale. Suntem pasionați de furnizarea soluțiilor ideale pentru nevoile de transport și gestionare a fluidelor în industrie.',
                'link' => '/multigama-tech-home/p',
            ],
            [
                'icon' => 'fa-screwdriver-wrench', // Font Awesome icon class
                'title' => 'Multigama Service',
                'description' => 'Multigama Service este un lider de necontestat în domeniul întreținerii, reparației și oferirii de soluții complete pentru pompele industriale. Cu o echipă experimentată și o abordare dedicată, ne angajăm să aducem performanță și fiabilitate în universul transportului și manipulării fluidelor în industrie.',
                'link' => '/multigama-service-home/p',
            ],
            [
                'icon' => 'fa-fire-extinguisher', // Font Awesome icon class
                'title' => 'EQ Fire',
                'description' => 'EQ Fire se remarcă ca lider de încredere în furnizarea și întreținerea sistemelor de stingere a incendiilor pentru mediul industrial. Ne angajăm să asigurăm protecția optimă împotriva incendiilor în facilitățile industriale, oferind soluții inovatoare și servicii de cea mai înaltă calitate.',
                'link' => '/multigama-eq-fire-home/p',
            ],
        ];


        $multiGamaGroupMenu = [
            [
                'name' => 'Multigama Group',
                'path' => '/',
                'sub_menu' => [
                    [
                        'name' => 'Multigama Tech',
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
                'name' => 'Despre Noi',
                'path' => '#about-us',
            ],
            [
                'name' => 'Misiune',
                'path' => '#mission',
            ],
            [
                'name' => 'Viziune',
                'path' => '#vision',
            ],
            [
                'name' => 'Contact',
                'path' => '#contact',
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
        $preloaderLogo = 'logo-multigama-group.png';

        if (str_contains($pageName, 'multigama-tech-')) {
            $contactEmail = 'multigama@multigama.ro';

            $logoList = [
                'multigama-tech' => [
                    'logo' => 'multigama-tech.png',
                    'preloaderLogo' => 'multigama-tech.png',
                    'skinVersion' => 'skin_3',
                ],
            ];
            $multiGamaGroupMenu = [
                [
                    'name' => 'Multigama Tech',
                    'path' => '/',
                    'sub_menu' => [
                        [
                            'name' => 'Multigama Group',
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
                [
                    'name' => 'Produse',
                    'path' => '/multigama-tech-products/p'
                ],
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

            $preloaderLogo = 'multigama-tech.png';

            $items = [
                [
                    'icon' => 'fa-arrow-up-from-water-pump', // Font Awesome icon class
                    'title' => 'Statii de Pompare',
                    'description' => 'Stațiile de pompare a apei joacă un rol crucial în asigurarea distribuției fiabile și eficiente a apei în cadrul comunităților. Aceste stații reprezintă inima sistemelor de alimentare cu apă, folosind pompe puternice pentru a ridica și a propulsa apa prin conducte, asigurându-se că ajunge la destinația sa, fie că este vorba de zone rezidențiale, comerciale sau industriale. De multe ori echipate cu tehnologie avansată și sisteme de monitorizare, aceste stații mențin presiunea apei, reglează fluxul și gestionează rețelele de distribuție.',
                    'link' => '/multigama-tech-home/p',
                ],
                [
                    'icon' => 'flaticon-agronomy', // Font Awesome icon class
                    'title' => 'Furnizare echipamente noi',
                    'description' => 'Furnizare echipamente noi, performante si eficiente din punct de vedere hidraulic și energetic. Furnizare piese de schimb pe toată durata de viață a echipamentelor',
                    'link' => '/multigama-service-home/p',
                ],
                [
                    'icon' => 'flaticon-crane', // Font Awesome icon class
                    'title' => 'Suport tehnic',
                    'description' => 'Suport tehnic în alegerea și dimensionarea echipamentelor pentru diverse tipuri de aplicații în funcție de necesitatea clientului. Suport tehnic în vederea înlocuirii echipamentelor vechi și neperformante etc.',
                    'link' => '/multigama-eq-fire-home/p',
                ],
            ];
        }

        if (str_contains($pageName, 'multigama-service-')) {
            $contactEmail = 'service@multigama.ro';

            $logoList = [
                'multigama-service' => [
                    'logo' => 'multigama-service.png',
                    'preloaderLogo' => 'multigama-service.png',
                    'skinVersion' => 'skin_4',
                ],
            ];
            $multiGamaGroupMenu = [
                [
                    'name' => 'Multigama Service',
                    'path' => '/',
                    'sub_menu' => [
                        [
                            'name' => 'Multigama Group',
                            'path' => '/',
                        ],
                        [
                            'name' => 'Multigama Tech',
                            'path' => '/multigama-tech-home/p',
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
                [
                    'name' => 'Produse',
                    'path' => '/multigama-service-products/p'
                ],
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

            $preloaderLogo = 'multigama-service.png';
            $skinVersion = 'skin_4';

            $items = [
                [
                    'icon' => 'screwdriver-wrench', // Font Awesome icon class
                    'title' => 'Mentenanta',
                    'description' => 'Mentenanța pompelor reprezintă un aspect esențial în menținerea funcționării optime a acestor dispozitive vitale în infrastructura de alimentare cu apă. Această practică implică o serie de activități preventive și corective menite să asigure funcționarea eficientă a pompelor pe termen lung. Serviciile periodice de întreținere includ verificări regulate, lubrifiere, verificarea și înlocuirea componentelor uzate sau deteriorate, precum și ajustarea parametrilor pentru a menține performanța optimă a pompelor. ',
                    'link' => '/multigama-service-home/p',
                ],
                [
                    'icon' => 'flaticon-agronomy', // Font Awesome icon class
                    'title' => 'Furnizare echipamente noi',
                    'description' => 'Furnizare echipamente noi, performante si eficiente din punct de vedere hidraulic și energetic. Furnizare piese de schimb pe toată durata de viață a echipamentelor',
                    'link' => '/multigama-service-home/p',
                ],
                [
                    'icon' => 'flaticon-crane', // Font Awesome icon class
                    'title' => 'Suport tehnic',
                    'description' => 'Suport tehnic în alegerea și dimensionarea echipamentelor pentru diverse tipuri de aplicații în funcție de necesitatea clientului. Suport tehnic în vederea înlocuirii echipamentelor vechi și neperformante etc.',
                    'link' => '/multigama-eq-fire-home/p',
                ],
            ];

        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            $logoList = [
                'multigama-eq-fire' => [
                    'logo' => 'eq-fire.png',
                    'preloaderLogo' => 'eq-fire.png',
                    'skinVersion' => 'skin_1',
                ],
            ];
            $multiGamaGroupMenu = [
                [
                    'name' => 'EQ Fire',
                    'path' => '/',
                    'sub_menu' => [
                        [
                            'name' => 'Multigama Group',
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

            $preloaderLogo = 'eq-fire.png';
            $skinVersion = 'skin_1';
            $items = [
                [
                    'icon' => 'fire-extinguisher', // Font Awesome icon class
                    'title' => 'Sisteme antiincendiu',
                    'description' => '"Sistemele de suprimare a incendiilor reprezintă o parte crucială a eforturilor noastre de protejare împotriva incendiilor în mediile industriale și comerciale. Aceste sisteme sunt proiectate pentru a detecta și a controla incendiile înainte ca acestea să se extindă, protejând viața oamenilor și proprietățile. Ele includ tehnologii avansate de detecție a incendiilor și metode eficiente de stins incendiile',
                    'link' => '/multigama-eq-fire-home/p',
                ],
                [
                    'icon' => 'flaticon-agronomy', // Font Awesome icon class
                    'title' => 'Furnizare echipamente noi',
                    'description' => 'Furnizare echipamente noi, performante si eficiente din punct de vedere hidraulic și energetic. Furnizare piese de schimb pe toată durata de viață a echipamentelor',
                    'link' => '/multigama-service-home/p',
                ],
                [
                    'icon' => 'flaticon-crane', // Font Awesome icon class
                    'title' => 'Suport tehnic',
                    'description' => 'Suport tehnic în alegerea și dimensionarea echipamentelor pentru diverse tipuri de aplicații în funcție de necesitatea clientului. Suport tehnic în vederea înlocuirii echipamentelor vechi și neperformante etc.',
                    'link' => '/multigama-eq-fire-home/p',
                ],

            ];
        }

        return $this->render("templates/pages/{$pageName}.html.twig", [
            'items' => $items,
            'multiGamaGroupMenu' => $multiGamaGroupMenu,
            'skinVersion' => $skinVersion,
            'contactEmail' => $contactEmail,
            'logo' => $logo,
            'preloaderLogo' => $preloaderLogo,
            'logoList' => $logoList,
            'slideshow' => $slideshow,
            'about' => $about,
            'aboutHeader' => $aboutHeader,
            'quickContactHeader' => $quickContactHeader,
            'quickContactContent' => $quickContactContent,
        ]);
    }
}
