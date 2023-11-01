<?php

namespace App\Controller\Admin\Page;

use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('dashboard/page/{id}', name: 'app_page_delete', methods: ['POST'])]
class PageDeleteController extends AbstractController
{
    public function __invoke(Request $request, Page $page, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$page->id, $request->request->get('_token'))) {
            $entityManager->remove($page);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_page_index', [], Response::HTTP_SEE_OTHER);

    }
}
