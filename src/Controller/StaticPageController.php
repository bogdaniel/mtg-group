<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class StaticPageController extends AbstractController
{
    private \Twig\Loader\LoaderInterface $loader;
    private ProjectRepository $projectRepository;
    private MailerInterface $mailer;

    public function __construct(Environment $twig, ProjectRepository $projectRepository, MailerInterface $mailer)
    {
        $this->loader = $twig->getLoader();

        $this->projectRepository = $projectRepository;
        $this->mailer = $mailer;
    }

    #[Route("/", name: "home")]
    public function home(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->redirectToRoute('static_page', ['pageName' => 'home']);
    }

    #[Route("/{pageName}/p", name: "static_page", defaults: ["pageName" => "home"])]
    public function loadPage(Request $request, EntityManagerInterface $entityManager, string $pageName = 'home'): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            $this->sendEmail($contact);
            return $this->redirectToRoute('static_page', ['pageName' => $pageName], Response::HTTP_SEE_OTHER);
        }

        $projects = [];
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
                'description' => 'Fondata in anul 1999, Multigama Tech ofera produse de cea mai mare calitate in Romania, prin partenerul sau de business KSB SEE, dar si prin alti parteneri de incredere. In acelasi timp, compania se ocupa de proiectarea si de dezvoltarea productiei de statii de pompare.',
                'link' => '/multigama-tech-home/p',
            ],
            [
                'icon' => 'fa-screwdriver-wrench', // Font Awesome icon class
                'title' => 'Multigama Service',
                'description' => 'Multigama Service este un partener exclusiv de service în România al KSB SEE. Serviciile oferite clientilor nostri sunt: Mentenanță preventivă, predictivă și corectivă, asistență tehnică la montarea și punerea în funcțiune a tuturor echipamentelor comercializate, furnizare echipamente noi, furnizare piese de schimb. suport tehnic în alegerea și dimensionarea echipamentelor pentru diverse tipuri de aplicații în funcție de necesitatea clientului, suport tehnic în vederea înlocuirii echipamentelor vechi și neperformante, etc. ',
                'link' => '/multigama-service-home/p',
            ],
            [
                'icon' => 'fa-fire-extinguisher', // Font Awesome icon class
                'title' => 'EQ Fire',
                'description' => 'Fondata in 2021, EQ Fire este membra a Multigama Group, si are ca obiect de acitivitate furnizarea de echipamente si servicii in domeniul protectiei impotriva incendiilor. Lucram cu mai multi furnizori de top: KSB Italia, SPP, Clarke, Armstrong, EBITT, etc.',
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
//            [
//                'name' => 'Sediu HQ',
//                'path' => '/multigama-group-sediu-hq/p',
//            ],
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
                'header' => 'Productie Statii Pompare <br />& Furnizare echipamente de pompare noi',
                'subheader' => '',
                'picture' => 'poza-1-tech.jpg',
            ],
            [
                'header' => 'Reparatii & Mentenanta',
                'subheader' => '',
                'picture' => 'poza-2-service.jpg',
            ],
            [
                'header' => 'Furnizare Echipamente Antiincendiu',
                'subheader' => '',
                'picture' => 'poza-3-eqfire.jpg',
            ],
        ];
        $slideshowHq = [
            [
                'header' => '',
                'subheader' => '',
                'picture' => 'render-slide-1.jpg',
            ],
            [
                'header' => '',
                'subheader' => '',
                'picture' => 'render-slide-2.jpg',
            ],
            [
                'header' => '',
                'subheader' => '',
                'picture' => 'render-slide-3.jpg',
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
            $contactEmail = 'office@multigama.ro';
            $logo = 'multigama-tech.png';

            $logoList = [
                'home' => [
                    'logo' => 'logo-multigama-group.png',
                    'preloaderLogo' => 'multigama-tech.png',
                    'skinVersion' => 'skin_3',
                ],
                'multigama-service-home' => [
                    'logo' => 'multigama-service.png',
                    'preloaderLogo' => 'multigama-service.png',
                    'skinVersion' => 'skin_4',
                ],
                'multigama-eq-fire-home' => [
                    'logo' => 'eq-fire.png',
                    'preloaderLogo' => 'eq-fire.png',
                    'skinVersion' => 'skin_1',
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
                    'path' => '#multigama-tech-about-us',
                ],
	            [
		            'name' => 'Statii Pompare',
		            'path' => '/multigama-tech-statii-pompare/p',
	            ],
                [
                    'name' => 'Produse',
                    'path' => '/multigama-tech-products/p'
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
                    'picture' => 'poza-1.jpg',
                ],
                [
                    'header' => 'Solutii Industriale <br/>Pentru Afacerea Ta',
                    'subheader' => '',
                    'picture' => 'poza-2.jpg',
                ],
                [
                    'header' => 'Servicii de mentenanță',
                    'subheader' => '',
                    'picture' => 'poza-3.jpg',
                ],
            ];
            $slideshow = [
                [
                    'header' => 'Statii de Pompare',
                    'subheader' => '',
                    'picture' => 'poza-1.jpg',
                ],
                [
                    'header' => 'Furnizare echipamente noi',
                    'subheader' => '',
                    'picture' => 'poza-2.jpg',
                ],
                [
                    'header' => 'Suport tehnic',
                    'subheader' => '',
                    'picture' => 'poza-3.jpg',
                ],
            ];
			if(str_contains($pageName, 'multigama-tech-statii-pompare')) {
                $slideshow = [
                    [
                        'header' => 'Multigama Tech',
                        'subheader' => '',
                        'picture' => 'poza-1.jpg',
                    ],
                    [
                        'header' => 'Multigama Service',
                        'subheader' => '',
                        'picture' => 'poza-2.jpg',
                    ],
                    [
                        'header' => 'EQ Fire',
                        'subheader' => '',
                        'picture' => 'poza-3.jpg',
                    ],
                ];
			}

            $aboutHeader = "Despre Noi";
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
                    'description' => 'Proiectam si dezvoltam productia de statii de pompare, cautand sa raspundem tuturor cerintelor clientilor nostri.',
                    'link' => '/multigama-tech-home/p',
                ],
                [
                    'icon' => 'fa-cogs', // Font Awesome icon class
                    'title' => 'Furnizare echipamente noi',
                    'description' => 'Multigama Tech ofera produse de cea mai buna calitate in Romania, la standarde Europene.',
                    'link' => '/multigama-service-home/p',
                ],
                [
                    'icon' => 'fa-user-tie', // Font Awesome icon class
                    'title' => 'Suport tehnic',
                    'description' => 'Oferim suport tehnic pentru alegerea si dimensionarea corecta a echipamentelor, respectand necesitatile clientilor nostri.',
                    'link' => '/multigama-eq-fire-home/p',
                ],
            ];
        }

        if (str_contains($pageName, 'multigama-service-')) {
            $contactEmail = 'office@multigama.ro';
            $logo = 'multigama-service.png';

            $logoList = [
                'home' => [
                    'logo' => 'logo-multigama-group.png',
                    'preloaderLogo' => 'multigama-group.png',
                    'skinVersion' => 'skin_3',
                ],
                'multigama-tech-home' => [
                    'logo' => 'multigama-tech.png',
                    'preloaderLogo' => 'multigama-tech.png',
                    'skinVersion' => 'skin_4',
                ],
                'multigama-eq-fire-home' => [
                    'logo' => 'eq-fire.png',
                    'preloaderLogo' => 'eq-fire.png',
                    'skinVersion' => 'skin_1',
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
                    'path' => '#multigama-service-about-us',
                ],
                [
                    'name' => 'Produse',
                    'path' => '/multigama-service-products/p'
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
                    'header' => 'Servicii de Mentenanta',
                    'subheader' => '',
                    'picture' => 'service-poza-1.jpg',
                ],
                [
                    'header' => 'Furnizare echipamente noi',
                    'subheader' => '',
                    'picture' => 'service-poza-2.jpg',
                ],
                [
                    'header' => 'Suport tehnic',
                    'subheader' => '',
                    'picture' => 'service-poza-3.jpg',
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
                    'icon' => 'fa-user-tie', // Font Awesome icon class
                    'title' => 'Servicii de Mentenanta',
                    'description' => 'Mentenanță preventivă, predictivă și corectivă pentru toate ansamblurile de echipamente. ',
                    'link' => '/multigama-service-home/p',
                ],
                [
                    'icon' => 'fa-cog', // Font Awesome icon class
                    'title' => 'Furnizare echipamente noi',
                    'description' => 'Furnizam echipamente noi, performante si eficiente din punct de vedere hidraulic și energetic. Furnizam piese de schimb pe toată durata de viață a echipamentelor',
                    'link' => '/multigama-service-home/p',
                ],
                [
                    'icon' => 'fa-user-tie', // Font Awesome icon class
                    'title' => 'Suport tehnic',
                    'description' => 'Suport tehnic în alegerea și dimensionarea echipamentelor pentru diverse tipuri de aplicații în funcție de necesitatea clientului cat si în vederea înlocuirii echipamentelor vechi și neperformante.',
                    'link' => '/multigama-eq-fire-home/p',
                ],
            ];

        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            $logo = 'eq-fire.png';
            $projects = $this->projectRepository->findAll();

            $logoList = [
                'home' => [
                    'logo' => 'logo-multigama-group.png',
                    'preloaderLogo' => 'multigama-group.png',
                    'skinVersion' => 'skin_3',
                ],
                'multigama-tech-home' => [
                    'logo' => 'multigama-tech.png',
                    'preloaderLogo' => 'multigama-tech.png',
                    'skinVersion' => 'skin_4',
                ],
                'multigama-service-home' => [
                    'logo' => 'multigama-service.png',
                    'preloaderLogo' => 'multigama-service.png',
                    'skinVersion' => 'skin_4',
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
                    'path' => '#multigama-eq-fire-about-us',
                ],
                [
                    'name' => 'Produse',
                    'path' => '/multigama-eq-fire-products/p',
//                    'sub_menu' => [
//                        [
//                            'name' => 'Armstrong',
//                            'path' => '#',
//                        ],
//                        [
//                            'name' => 'Armstrong HSC',
//                            'path' => '/multigama-eq-fire-armstrong-hsc/p',
//                        ],
//                        [
//                            'name' => 'Armstrong VIL',
//                            'path' => '/multigama-eq-fire-armstrong-vil/p',
//                        ],
//                        [
//                            'name' => 'Armstrong ES',
//                            'path' => '/multigama-eq-fire-armstrong-es/p',
//                        ],
//                    ],
                ],
//                [
//                    'name' => 'Servicii',
//                    'path' => '/multigama-eq-fire-services/p',
//                    'sub_menu' => [
//                        [
//                            'name' => 'Servicii',
//                            'path' => '/multigama-eq-fire-services/p',
//                        ],
//                        [
//                            'name' => 'Detalii Serviciu',
//                            'path' => '/multigama-eq-fire-services-details/p',
//                        ],
//                    ],
//                ],
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
                    'header' => 'Furnizare echipamente antiincendiu',
                    'subheader' => '',
                    'picture' => 'eqfire-poza-1.jpg',
                ],
                [
                    'header' => 'Solutii tehnice personalizate',
                    'subheader' => '',
                    'picture' => 'eqfire-poza-2.jpg',
                ],
                [
                    'header' => 'Personal specializat',
                    'subheader' => '',
                    'picture' => 'eqfire-poza-3.jpg',
                ],
            ];
            $aboutHeader = "Siguranță de Încredere cu EQ Fire pentru Sisteme de Stingere a Incendiilor";
            $about = "
Fondata in 2021, EQ Fire este membra a Multigama Group, si are ca obiect de acitivitate  furnizarea de echipamente si servicii in domeniul protectiei impotriva incendiilor.
Societatea noastra va ofera produsele si solutiile potrivite pentru fiecare cerinta - de la vane, vase de expansiune,  sisteme de mentinere a presiunii, pana la grupuri de pompare pentru sistemele de stingere cu hidranti, sprinklere sau spuma.
EQ Fire are implementat un sistem de management al calitatii si este certificata ISO9001:2015, ISO14001:2015 si ISO45001:2018.

";
            $quickContactHeader = "MULTIGAMA SERVICE";
            $quickContactContent = "";

            $preloaderLogo = 'eq-fire.png';
            $skinVersion = 'skin_1';
            $items = [
                [
                    'icon' => 'fa-shield-alt', // Font Awesome icon class
                    'title' => 'Axati pe rezultate',
                    'description' => 'Scopul nostru este de a ne ajutam clientii sa obtina cea mai buna solutie tehnica. De aceea, ne angajam sa oferim solutii complete care sa va ajute sa reusiti in piata competitiva de astazi',
                    'link' => '/multigama-eq-fire-home/p',
                ],
                [
                    'icon' => 'fa-cog', // Font Awesome icon class
                    'title' => 'Furnizare echipamente noi',
                    'description' => 'Suntem angajati sa ajutam clientii sa obtina cea mai buna solutie tehnica. De aceea, ne angajam sa oferim solutii complete care sa va ajute sa reusiti in piata competitiva de astazi.Oferim o gama larga de echipamente pentru stins incendiu NFPA 20 certificate FM/UL, VdS, EN12845',
                    'link' => '/multigama-service-home/p',
                ],
                [
                    'icon' => 'fa-puzzle-piece', // Font Awesome icon class
                    'title' => 'Solutii tehnice personalizate',
                    'description' => 'Echipa noastra va lucra indeaproape cu dumneavoastră pentru a dezvolta un produs personalizat care sa raspunda solicitarii si cerintelor dumneavoastra',
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
            'slideshowHq' => $slideshowHq,
            'projects' => $projects,
            'form' => $form,
            'pageName' => $pageName,
        ]);
    }

    public function sendEmail($params): void
    {
        $email = (new Email())
            ->from('website@multigama.ro')
            ->addReplyTo($params->getEmail())
            ->to('office@multigama.ro')
            ->priority(Email::PRIORITY_HIGH)
            ->subject('[WEBSITE][Multigama] Contact Form ' . $params->getName() . ' - ' . $params->getEmail())
            ->text($params->getMessage());

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            mail('bogdan@zenchron.com', '[WEBSITE][MULTIGAMA] Error sending email', $e->getMessage());
        }
        // ...
    }

}
