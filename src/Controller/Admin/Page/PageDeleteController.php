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
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_page_delete', ['id' => $page->id]))
            ->setMethod('DELETE')
            ->getForm();

        $handleFormSubmission = $this->handleFormSubmission($form, function () use ($pageManager, $pageMetaManager, $page) {
            $pageMetaManager->deletePageMeta($page->pageMeta);
            $pageManager->deletePage($page);
            return $this->redirectToRoute('app_page_index', [], Response::HTTP_SEE_OTHER);
        });

        $response = $handleFormSubmission($request);
        return $response ?? $this->render('templates/admin/page/delete.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }
}
