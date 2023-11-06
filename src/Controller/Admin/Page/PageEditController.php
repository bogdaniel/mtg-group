<?php

namespace App\Controller\Admin\Page;

use App\Entity\Page;
use App\Form\PageType;
use App\Service\PageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/page/{id}/edit', name: 'app_page_edit', methods: ['GET', 'POST'])]
class PageEditController extends AbstractController
{
    public function __invoke(Request $request, Page $page, PageManager $pageManager): Response
    {
        if ($page->getPageMeta() === null) {
            $pageMeta = new PageMeta();
            $page->setPageMeta($pageMeta);
        }

        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pageManager->updatePage($page);

            return $this->redirectToRoute('app_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('templates/admin/page/edit.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }
}
