<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\LocaleSwitcher;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Loader\LoaderInterface;

class StaticPageController extends AbstractController
{
    private LoaderInterface $loader;
    private ProjectRepository $projectRepository;
    private MailerInterface $mailer;
    private TranslatorInterface $translator;
    private LocaleSwitcher $localeSwitcher;

    public function __construct(Environment $twig, ProjectRepository $projectRepository, MailerInterface $mailer, TranslatorInterface $translator, LocaleSwitcher $localeSwitcher)
    {
        $this->loader = $twig->getLoader();

        $this->projectRepository = $projectRepository;
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->localeSwitcher = $localeSwitcher;
    }

    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->redirectToRoute('static_page', ['pageName' => 'home']);
    }

    #[Route("/change-locale/{locale}", name: "change_locale")]
    public function changeLocale(string $locale, Request $request, SessionInterface $session): Response
    {
        // Check if the requested locale is supported
        $supportedLocales = ['en', 'ro']; // Add your supported locales here
        if (!in_array($locale, $supportedLocales)) {
            throw $this->createNotFoundException('Locale not supported');
        }

        // Set the locale in the session
        $session->set('_locale', $locale);

        // Set the locale in the request
        $request->setLocale($locale);
        $this->localeSwitcher->setLocale($locale);

        // Optionally, add a flash message to notify the user
//        $this->addFlash('success', 'Language changed successfully!');

        // Redirect back to the previous page
        $referer = $request->headers->get('referer');
        return $this->redirect($referer ?: $this->generateUrl('home'));
    }

    #[Route("/{pageName}/p", name: "static_page", defaults: ["pageName" => "home"])]
    public function loadPage(
        Request $request,
        EntityManagerInterface $entityManager,
        SessionInterface $session,
        string $pageName = 'home'
    ): Response {

        $this->localeSwitcher->setLocale($session->get('_locale', 'en'));

        $form = $this->handleContactForm($request, $entityManager, $pageName);
        $logoUrl = $this->getLogoUrl($pageName);
        $logoList = $this->getLogoList($pageName);
        $slideshow = $this->getSlideshow($pageName);
        $preloaderLogo = $this->getPreloaderLogo($pageName);
        $skinVersion = $this->getSkinVersion($pageName);
        $logo = $this->getLogo($pageName);
        $items = $this->getItems($pageName);
        $multiGamaGroupMenu = $this->getMultiGamaGroupMenu($pageName);
        $aboutHeader = $this->getAboutHeader($pageName);
        $about = $this->getAboutContent($pageName);

        $quickContactHeader = $this->getQuickContactHeader($pageName);
        $quickContactContent = $this->getQuickContactContent($pageName);
        $projects = $this->getProjectsForPage($pageName);
        $contactEmail = 'office@multigama.ro';

        if (str_contains($pageName, 'multigama-tech-')) {
            if (str_contains($pageName, 'multigama-tech-statii-pompare')) {
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
            'projects' => $projects,
            'form' => $form,
            'pageName' => $pageName,
            'logoUrl' => $logoUrl,
        ]);
    }

    private function handleContactForm(
        Request $request,
        EntityManagerInterface $entityManager,
        string $pageName,
    ): FormInterface {
        $form = $this->createContactForm($request);
        $this->submitContactForm($form, $entityManager, $pageName);

        return $form;
    }

    private function createContactForm(Request $request): FormInterface
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        return $form;
    }

    private function submitContactForm(
        FormInterface $form,
        EntityManagerInterface $entityManager,
        string $pageName,
    ): void {
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $entityManager->persist($contact);
            $entityManager->flush();

            $this->sendEmail($contact);

            // Add flash message
            $this->addFlash('success', 'Mesajul a fost trimis cu succes!');

            $this->redirectToRoute('static_page', ['pageName' => $pageName], Response::HTTP_SEE_OTHER);
            return;
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('success', 'Mesajul nu s-a putut trimite!');
        }
    }

    public function sendEmail($params): void
    {
        $email = (new Email())->from('website@multigama.ro')->addReplyTo($params->getEmail())->to(
            'office@multigama.ro',
        )->priority(Email::PRIORITY_HIGH)->subject(
            '[WEBSITE][Multigama] Contact Form ' . $params->getName() . ' - ' . $params->getEmail(),
        )->text($params->getMessage());

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            mail('bogdan@zenchron.com', '[WEBSITE][MULTIGAMA] Error sending email', $e->getMessage());
        }
    }

    private function getLogoUrl(string $pageName): string
    {
        if (str_contains($pageName, 'multigama-tech-')) {
            return $this->generateUrl('static_page', ['pageName' => 'multigama-tech-home']);
        }

        if (str_contains($pageName, 'multigama-service-')) {
            return $this->generateUrl('static_page', ['pageName' => 'multigama-service-home']);
        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            return $this->generateUrl('static_page', ['pageName' => 'multigama-eq-fire-home']);
        }

        return $this->generateUrl('static_page', ['pageName' => 'home']);
    }

    private function getLogoList(string $pageName): array
    {
        if (str_contains($pageName, 'multigama-tech-')) {
            return [
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
        }

        if (str_contains($pageName, 'multigama-service-')) {
            return [
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
        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            return [
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
        }

        return [
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
    }

    private function getSlideshow(string $pageName): array
    {
        if (str_contains($pageName, 'multigama-tech-')) {
            return [
                [
                    'header' => $this->translator->trans('Statii de Pompare'),
                    'subheader' => '',
                    'picture' => 'poza-1.jpg',
                ],
                [
                    'header' => $this->translator->trans('Furnizare echipamente noi'),
                    'subheader' => '',
                    'picture' => 'poza-2.jpg',
                ],
                [
                    'header' => $this->translator->trans('Suport tehnic'),
                    'subheader' => '',
                    'picture' => 'poza-3.jpg',
                ],
            ];
        }

        if (str_contains($pageName, 'multigama-service-')) {
            return [
                [
                    'header' => $this->translator->trans('Servicii de Mentenanta'),
                    'subheader' => '',
                    'picture' => 'service-poza-1.jpg',
                ],
                [
                    'header' => $this->translator->trans('Furnizare echipamente noi'),
                    'subheader' => '',
                    'picture' => 'service-poza-2.jpg',
                ],
                [
                    'header' => $this->translator->trans('Suport tehnic'),
                    'subheader' => '',
                    'picture' => 'service-poza-3.jpg',
                ],
            ];
        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            return [
                [
                    'header' => $this->translator->trans('Furnizare Echipamente Antiincendiu'),
                    'subheader' => '',
                    'picture' => 'eqfire-poza-1.jpg',
                ],
                [
                    'header' => $this->translator->trans('Solutii tehnice personalizate'),
                    'subheader' => '',
                    'picture' => 'eqfire-poza-2.jpg',
                ],
                [
                    'header' => $this->translator->trans('Personal specializat'),
                    'subheader' => '',
                    'picture' => 'eqfire-poza-3.jpg',
                ],
            ];
        }

        return [
            [
                'header' => $this->translator->trans('Productie Statii Pompare <br />& Furnizare echipamente de pompare noi'),
                'subheader' => '',
                'picture' => 'poza-1-tech.jpg',
            ],
            [
                'header' => $this->translator->trans('Reparatii & Mentenanta'),
                'subheader' => '',
                'picture' => 'poza-2-service.jpg',
            ],
            [
                'header' => $this->translator->trans('Furnizare Echipamente Antiincendiu'),
                'subheader' => '',
                'picture' => 'poza-3-eqfire.jpg',
            ],
        ];
    }

    private function getPreloaderLogo(string $pageName): string
    {
        if (str_contains($pageName, 'multigama-tech-')) {
            return 'multigama-tech.png';
        }

        if (str_contains($pageName, 'multigama-service-')) {
            return 'multigama-service.png';
        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            return 'eq-fire.png';
        }

        return 'logo-multigama-group.png';
    }

    private function getSkinVersion(string $pageName): string
    {
        if (str_contains($pageName, 'multigama-tech-')) {
            return 'skin_3';
        }

        if (str_contains($pageName, 'multigama-service-')) {
            return 'skin_4';
        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            return 'skin_1';
        }

        return 'skin_3';
    }

    private function getLogo(string $pageName): string
    {
        if (str_contains($pageName, 'multigama-tech-')) {
            return 'multigama-tech.png';
        }

        if (str_contains($pageName, 'multigama-service-')) {
            return 'multigama-service.png';
        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            return 'eq-fire.png';
        }

        return 'logo-multigama-group.png';
    }

    private function getItems(string $pageName): array
    {
        if (str_contains($pageName, 'multigama-tech-')) {
            return [
                [
                    'icon' => 'fa-arrow-up-from-water-pump',
                    'title' => $this->translator->trans('Statii de Pompare'),
                    'description' => $this->translator->trans('Proiectam si dezvoltam productia de statii de pompare, cautand sa raspundem tuturor cerintelor clientilor nostri.'),
                    'link' => '/multigama-tech-home/p',
                ],
                [
                    'icon' => 'fa-cogs',
                    'title' => $this->translator->trans('Furnizare echipamente noi'),
                    'description' => $this->translator->trans('Multigama Tech ofera produse de cea mai buna calitate in Romania, la standarde Europene.'),
                    'link' => '/multigama-service-home/p',
                ],
                [
                    'icon' => 'fa-user-tie',
                    'title' => $this->translator->trans('Suport tehnic'),
                    'description' => $this->translator->trans('Oferim suport tehnic pentru alegerea si dimensionarea corecta a echipamentelor, respectand necesitatile clientilor nostri.'),
                    'link' => '/multigama-eq-fire-home/p',
                ],
            ];
        }

        if (str_contains($pageName, 'multigama-service-')) {
            return [
                [
                    'icon' => 'fa-user-tie',
                    'title' => $this->translator->trans('Servicii de Mentenanta'),
                    'description' => $this->translator->trans('Mentenanță preventivă, predictivă și corectivă pentru toate ansamblurile de echipamente.'),
                    'link' => '/multigama-service-home/p',
                ],
                [
                    'icon' => 'fa-cog',
                    'title' => $this->translator->trans('Furnizare echipamente noi'),
                    'description' => $this->translator->trans('Furnizam echipamente noi, performante si eficiente din punct de vedere hidraulic și energetic. Furnizam piese de schimb pe toată durata de viață a echipamentelor.'),
                    'link' => '/multigama-service-home/p',
                ],
                [
                    'icon' => 'fa-user-tie',
                    'title' => $this->translator->trans('Suport tehnic'),
                    'description' => $this->translator->trans('Suport tehnic în alegerea și dimensionarea echipamentelor pentru diverse tipuri de aplicații în funcție de necesitatea clientului cat si în vederea înlocuirii echipamentelor vechi și neperformante.'),
                    'link' => '/multigama-service-home/p',
                ],
            ];
        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            return [
                [
                    'icon' => 'fa-shield-alt', // Font Awesome icon class
                    'title' => $this->translator->trans('Axati pe rezultate'),
                    'description' => $this->translator->trans('Scopul nostru este de a ne ajutam clientii sa obtina cea mai buna solutie tehnica. De aceea, ne angajam sa oferim solutii complete care sa va ajute sa reusiti in piata competitiva de astazi'),
                    'link' => '/multigama-eq-fire-home/p',
                ],
                [
                    'icon' => 'fa-cog', // Font Awesome icon class
                    'title' => $this->translator->trans('Furnizare echipamente noi'),
                    'description' => $this->translator->trans('Suntem angajati sa ajutam clientii sa obtina cea mai buna solutie tehnica. De aceea, ne angajam sa oferim solutii complete care sa va ajute sa reusiti in piata competitiva de astazi.Oferim o gama larga de echipamente pentru stins incendiu NFPA 20 certificate FM/UL, VdS, EN12845'),
                    'link' => '/multigama-service-home/p',
                ],
                [
                    'icon' => 'fa-puzzle-piece', // Font Awesome icon class
                    'title' => $this->translator->trans('Solutii tehnice personalizate'),
                    'description' => $this->translator->trans('Echipa noastra va lucra indeaproape cu dumneavoastră pentru a dezvolta un produs personalizat care sa raspunda solicitarii si cerintelor dumneavoastra'),
                    'link' => '/multigama-eq-fire-home/p',
                ],
            ];
        }

        // Default items for other pages
        return [
            [
                'icon' => 'fa-arrow-up-from-water-pump', // Font Awesome icon class
                'title' => $this->translator->trans('Multigama Tech'),
                'description' => $this->translator->trans('Fondata in anul 1999, Multigama Tech ofera produse de cea mai mare calitate in Romania, prin partenerul sau de business KSB SEE, dar si prin alti parteneri de incredere. In acelasi timp, compania se ocupa de proiectarea si de dezvoltarea productiei de statii de pompare.'),
                'link' => '/multigama-tech-home/p',
            ],
            [
                'icon' => 'fa-screwdriver-wrench', // Font Awesome icon class
                'title' => $this->translator->trans('Multigama Service'),
                'description' => $this->translator->trans('Multigama Service este un partener exclusiv de service în România al KSB SEE. Serviciile oferite clientilor nostri sunt: Mentenanță preventivă, predictivă și corectivă, asistență tehnică la montarea și punerea în funcțiune a tuturor echipamentelor comercializate, furnizare echipamente noi, furnizare piese de schimb. suport tehnic în alegerea și dimensionarea echipamentelor pentru diverse tipuri de aplicații în funcție de necesitatea clientului, suport tehnic în vederea înlocuirii echipamentelor vechi și neperformante, etc.'),
                'link' => '/multigama-service-home/p',
            ],
            [
                'icon' => 'fa-fire-extinguisher', // Font Awesome icon class
                'title' => $this->translator->trans('EQ Fire'),
                'description' => $this->translator->trans('Fondata in 2021, EQ Fire este membra a Multigama Group, si are ca obiect de acitivitate furnizarea de echipamente si servicii in domeniul protectiei impotriva incendiilor. Lucram cu mai multi furnizori de top: KSB Italia, SPP, Clarke, Armstrong, EBITT, etc.'),
                'link' => '/multigama-eq-fire-home/p',
            ],
        ];
    }

    private function getMultiGamaGroupMenu(string $pageName): array
    {
        if (str_contains($pageName, 'multigama-tech-')) {
            return [
                [
                    'name' => 'Multigama Tech',
                    'path' => '/',
                    'class' => '',
                    'sub_menu' => [
                        [
                            'name' => 'Multigama Group',
                            'path' => '/',
                            'class' => '',
                        ],
                        [
                            'name' => 'Multigama Service',
                            'path' => '/multigama-service-home/p',
                            'class' => '',
                        ],
                        [
                            'name' => 'EQ Fire',
                            'path' => '/multigama-eq-fire-home/p',
                            'class' => '',
                        ],
                    ],
                ],
                [
                    'name' => 'Despre Noi',
                    'path' => '/multigama-tech-home/p#multigama-tech-about-us',
                    'class' => 'page-scroll',
                ],
                [
                    'name' => 'Statii Pompare',
                    'path' => '/multigama-tech-statii-pompare/p',
                    'class' => '',
                ],
                [
                    'name' => 'Produse',
                    'path' => '/multigama-tech-products/p',
                    'class' => '',
                ],
                [
                    'name' => 'Proiecte',
                    'path' => '/multigama-tech-portfolio/p',
                    'class' => '',
                ],
                [
                    'name' => 'Contact',
                    'path' => '/multigama-tech-contact-us/p',
                    'class' => '',
                ],
            ];
        }

        if (str_contains($pageName, 'multigama-service-')) {
            return [
                [
                    'name' => 'Multigama Service',
                    'path' => '/',
                    'class' => '',
                    'sub_menu' => [
                        [
                            'name' => 'Multigama Group',
                            'path' => '/',
                            'class' => '',
                        ],
                        [
                            'name' => 'Multigama Tech',
                            'path' => '/multigama-tech-home/p',
                            'class' => '',
                        ],
                        [
                            'name' => 'EQ Fire',
                            'path' => '/multigama-eq-fire-home/p',
                            'class' => '',
                        ],
                    ],
                ],
                [
                    'name' => 'Despre Noi',
                    'path' => '/multigama-service-home/p#multigama-service-about-us',
                    'class' => 'page-scroll',
                ],
                [
                    'name' => 'Produse',
                    'path' => '/multigama-service-products/p',
                    'class' => '',
                ],
                [
                    'name' => 'Proiecte',
                    'path' => '/multigama-service-portfolio/p',
                    'class' => '',
                ],
                [
                    'name' => 'Contact',
                    'path' => '/multigama-service-contact-us/p',
                    'class' => '',
                ],
            ];
        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            return [
                [
                    'name' => 'EQ Fire',
                    'path' => '/',
                    'sub_menu' => [
                        [
                            'name' => 'Multigama Group',
                            'path' => '/',
                            'class' => '',
                        ],
                        [
                            'name' => 'Multigama Service',
                            'path' => '/multigama-service-home/p',
                            'class' => '',
                        ],
                        [
                            'name' => 'EQ Fire',
                            'path' => '/multigama-eq-fire-home/p',
                            'class' => '',
                        ],
                    ],
                ],
                [
                    'name' => 'Despre Noi',
                    'path' => '/multigama-eq-fire-home/p#multigama-eq-fire-about-us',
                    'class' => 'page-scroll',
                ],
                [
                    'name' => 'Produse',
                    'path' => '/multigama-eq-fire-products/p',
                    'class' => '',
                ],
                [
                    'name' => 'Proiecte',
                    'path' => '/multigama-eq-fire-portfolio/p',
                    'class' => '',
                ],
                [
                    'name' => 'Contact',
                    'path' => '/multigama-eq-fire-contact-us/p',
                    'class' => '',
                ],
            ];
        }

        // Default menu for the homepage or other pages
        return [
            [
                'name' => 'Multigama Group',
                'path' => '/',
                'sub_menu' => [
                    [
                        'name' => 'Multigama Tech',
                        'path' => '/multigama-tech-home/p',
                        'class' => '',
                    ],
                    [
                        'name' => 'Multigama Service',
                        'path' => '/multigama-service-home/p',
                        'class' => '',
                    ],
                    [
                        'name' => 'EQ Fire',
                        'path' => '/multigama-eq-fire-home/p',
                        'class' => '',
                    ],
                ],
            ],
            [
                'name' => 'Despre Noi',
                'path' => '#about-us',
                'class' => 'page-scroll',
            ],
            [
                'name' => 'Misiune & Viziune',
                'path' => '#mission',
                'class' => 'page-scroll',
            ],
            [
                'name' => 'Contact',
                'path' => '#contact',
                'class' => 'page-scroll',
            ],
        ];
    }

    private function getAboutHeader(string $pageName): string
    {
        if (str_contains($pageName, 'multigama-tech-')) {
            return $this->translator->trans("Despre Noi");
        }

        if (str_contains($pageName, 'multigama-service-')) {
            return "Expertiza Multigama Service în Soluții Complete pentru Pompe Industriale!";
        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            return "Siguranță de Încredere cu EQ Fire pentru Sisteme de Stingere a Incendiilor";
        }

        return "Povestea Noastra!";
    }

    private function getAboutContent(string $pageName): string
    {
        if (str_contains($pageName, 'multigama-tech-')) {
            return "Cu o experiență vastă și o dedicare neclintită față de excelență, Multigama Tech se află în fruntea industriei de vânzare a pompelor industriale. Suntem pasionați de furnizarea soluțiilor ideale pentru nevoile de transport și gestionare a fluidelor în industrie.

        Specializați în furnizarea unei game complete de pompe industriale, de la cele de uz general până la cele specializate pentru aplicații specifice, ne străduim să aducem inovație și performanță fiecărui partener industrial.";
        }

        if (str_contains($pageName, 'multigama-service-')) {
            return "Multigama Service este un lider de necontestat în domeniul întreținerii, reparației și
                oferirii de soluții complete pentru pompele industriale. Cu o echipă experimentată și o
                abordare dedicată, ne angajăm să aducem performanță și fiabilitate în universul
                transportului și manipulării fluidelor în industrie.";
        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            return "Fondata in 2021, EQ Fire este membra a Multigama Group, si are ca obiect de acitivitate furnizarea de echipamente si servicii in domeniul protectiei impotriva incendiilor.
                Societatea noastra va ofera produsele si solutiile potrivite pentru fiecare cerinta - de la vane, vase de expansiune, sisteme de mentinere a presiunii, pana la grupuri de pompare pentru sistemele de stingere cu hidranti, sprinklere sau spuma.
                EQ Fire are implementat un sistem de management al calitatii si este certificata ISO9001:2015, ISO14001:2015 si ISO45001:2018.";
        }

        // Default about content
        return "Cu o activitate de peste 32 de ani, Multigama Grup, alcătuită din firmele SC Multigama Tech SRL, SC Multigama Service SRL și EQ Fire SRL asigură clienților
            săi atât pe piața internă cât și pe cea internațională echipamente noi performante, piese de schimb și mentenanță la cele mai înalte standarde pentru pompe,
            grupuril de pompare, stații de pompare și echipamentele de stingere a incendiilor.";
    }

    private function getQuickContactHeader(string $pageName): string
    {
        if (str_contains($pageName, 'multigama-tech-')) {
            return "MULTIGAMA TECH";
        }

        if (str_contains($pageName, 'multigama-service-')) {
            return "MULTIGAMA SERVICE";
        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            return "MULTIGAMA SERVICE";
        }

        return "MULTIGAMA GROUP";
    }

    private function getQuickContactContent(string $pageName): string
    {
        if (str_contains($pageName, 'multigama-tech-')) {
            return "";
        }

        if (str_contains($pageName, 'multigama-service-')) {
            return "";
        }

        if (str_contains($pageName, 'multigama-eq-fire-')) {
            return "";
        }

        return "Povestea grupului Multigama a început cu firma Multigama Industrial, înființată la 4 decembrie 1990 de un grup de ingineri, foști angajați ai companiei AVERSA, specializați în domeniul pompelor. Principalul obiectiv a fost de a vinde și produce pompe pentru uz casnic care nu existau pe piața românească de la acea vreme.";
    }

    private function getProjectsForPage(string $pageName): array
    {
        if (str_contains($pageName, 'multigama-eq-fire-')) {
            return $this->projectRepository->findAll();
        }

        // Default empty projects array
        return [];
    }

}
