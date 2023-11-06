<?php

namespace App\Controller\Admin\Page;

use App\Entity\Page;
use App\Entity\PageMeta;
use App\Form\PageType;
use App\Service\PageManager;
use App\Service\PageMetaManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/page/new', name: 'app_page_new', methods: ['GET', 'POST'])]
class PageNewController extends AbstractController
{
    public function __invoke(Request $request, PageManager $pageManager, PageMetaManager $pageMetaManager): Response
    {
        $page = new Page();
        $pageMeta = new PageMeta();
        $page->setPageMeta($pageMeta);
        $form = $this->createForm(PageType::class, $page);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pageMetaManager->createPageMeta($pageMeta);
            $pageManager->createPage($page);

            return $this->redirectToRoute('app_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('templates/admin/page/new.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }
}
