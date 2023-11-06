<?php

namespace App\Controller\Admin\Page;

use App\Controller\BaseController;
use App\Service\PageManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/page', name: 'app_page_index', methods: ['GET'])]
class PageIndexController extends BaseController
{
    public function __invoke(PageManager $pageManager): Response
    {
        return $this->render('templates/admin/page/index.html.twig', [
            'pages' => $pageManager->getAllPages(),
        ]);
    }
}
