<?php

namespace App\Controller\Admin\Page;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/page', name: 'app_page_index', methods: ['GET'])]
class PageIndexController extends AbstractController
{
    public function __invoke(PageRepository $pageRepository): Response
    {
        return $this->render('templates/admin/page/index.html.twig', [
            'pages' => $pageRepository->findAll(),
        ]);
    }
}
