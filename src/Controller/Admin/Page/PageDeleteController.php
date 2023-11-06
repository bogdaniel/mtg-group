<?php

namespace App\Controller\Admin\Page;

use App\Controller\BaseController;
use App\Entity\Page;
use App\Factory\PageFactory;
use App\Factory\PageMetaFactory;
use App\Service\PageManager;
use App\Service\PageMetaManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('dashboard/page/delete/{id}', name: 'app_page_delete', methods: ['POST'])]
class PageDeleteController extends BaseController
{
    public function __invoke(Request $request, Page $page, PageManager $pageManager, PageMetaManager $pageMetaManager, PageMetaFactory $pageMetaFactory, PageFactory $pageFactory
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $page->id, $request->request->get('_token'))) {
            $pageMeta = $pageMetaFactory->create();
            $pageMetaManager->deletePageMeta($pageMeta);
        }

        return $this->redirectToRoute('app_page_index', [], Response::HTTP_SEE_OTHER);
    }
}
