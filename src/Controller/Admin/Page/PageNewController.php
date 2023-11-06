<?php

namespace App\Controller\Admin\Page;

use App\Controller\BaseController;
use App\Factory\PageFactory;
use App\Factory\PageMetaFactory;
use App\Form\PageType;
use App\Service\PageManager;
use App\Service\PageMetaManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/page/new', name: 'app_page_new', methods: ['GET', 'POST'])]
class PageNewController extends BaseController
{
    public function __invoke(Request $request, PageManager $pageManager, PageMetaManager $pageMetaManager, PageMetaFactory $pageMetaFactory, PageFactory $pageFactory): Response
    {
        $page = $pageFactory->create();
        $pageMeta = $pageMetaFactory->create();
        $page->setPageMeta($pageMeta);
        $form = $this->createForm(PageType::class, $page);

        $handleFormSubmission = $this->handleFormSubmission($form, function ($data) use ($pageManager, $pageMetaManager, $page, $pageMeta) {
            $pageMetaManager->createPageMeta($pageMeta);
            $pageManager->createPage($page);
            return $this->redirectToRoute('app_page_index', [], Response::HTTP_SEE_OTHER);
        });

        $response = $handleFormSubmission($request);
        if ($response !== null) {
            return $response;
        }

        return $this->render('templates/admin/page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }
}
