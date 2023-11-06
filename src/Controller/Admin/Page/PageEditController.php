<?php

namespace App\Controller\Admin\Page;

use App\Controller\BaseController;
use App\Entity\Page;
use App\Factory\PageFactory;
use App\Factory\PageMetaFactory;
use App\Form\PageType;
use App\Service\PageManager;
use App\Service\PageMetaManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/page/{id}/edit', name: 'app_page_edit', methods: ['GET', 'POST'])]
class PageEditController extends BaseController
{
    public function __invoke(Request $request, Page $page, PageManager $pageManager, PageMetaManager $pageMetaManager, PageMetaFactory $pageMetaFactory, PageFactory $pageFactory): Response
    {
        if ($page->pageMeta === null) {
            $pageMeta = $pageMetaFactory->create();
            $page->setPageMeta($pageMeta);
        }

        $form = $this->createForm(PageType::class, $page);

        $handleFormSubmission = $this->handleFormSubmission($form, function () use ($pageManager, $pageMetaManager, $page) {
            $pageMetaManager->updatePageMeta($page->pageMeta);
            $pageManager->updatePage($page);
            return $this->redirectToRoute('app_page_index', [], Response::HTTP_SEE_OTHER);
        });

        $response = $handleFormSubmission($request);
        return $response ?? $this->render('templates/admin/page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }
}
