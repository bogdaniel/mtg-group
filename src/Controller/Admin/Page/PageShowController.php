<?php

namespace App\Controller\Admin\Page;

use App\Controller\BaseController;
use App\Entity\Page;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/page//{id}', name: 'app_page_show', methods: ['GET'])]
class PageShowController extends BaseController
{
    public function __invoke(Page $page): Response
    {
        return $this->render('templates/admin/page/show.html.twig', [
            'page' => $page,
        ]);
    }
}
