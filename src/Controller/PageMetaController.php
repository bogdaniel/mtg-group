<?php

namespace App\Controller;

use App\Entity\PageMeta;
use App\Form\PageMetaType;
use App\Repository\PageMetaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/page/meta')]
class PageMetaController extends AbstractController
{
    #[Route('/', name: 'app_page_meta_index', methods: ['GET'])]
    public function index(PageMetaRepository $pageMetaRepository): Response
    {
        return $this->render('page_meta/index.html.twig', [
            'page_metas' => $pageMetaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_page_meta_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pageMetum = new PageMeta();
        $form = $this->createForm(PageMetaType::class, $pageMetum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pageMetum);
            $entityManager->flush();

            return $this->redirectToRoute('app_page_meta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('page_meta/new.html.twig', [
            'page_metum' => $pageMetum,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_page_meta_show', methods: ['GET'])]
    public function show(PageMeta $pageMetum): Response
    {
        return $this->render('page_meta/show.html.twig', [
            'page_metum' => $pageMetum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_page_meta_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PageMeta $pageMetum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PageMetaType::class, $pageMetum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_page_meta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('page_meta/edit.html.twig', [
            'page_metum' => $pageMetum,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_page_meta_delete', methods: ['POST'])]
    public function delete(Request $request, PageMeta $pageMetum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pageMetum->id, $request->request->get('_token'))) {
            $entityManager->remove($pageMetum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_page_meta_index', [], Response::HTTP_SEE_OTHER);
    }
}
