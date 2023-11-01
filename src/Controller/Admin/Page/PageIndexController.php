<?php

namespace App\Controller\Admin\Page;

use App\Repository\PageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/page', name: 'app_page_index', methods: ['GET'])]
class PageIndexController
{
    public function __invoke(PageRepository $pageRepository): Response
    {
        return $this->render('page/index.html.twig', [
            'pages' => $pageRepository->findAll(),
        ]);
    }
}
