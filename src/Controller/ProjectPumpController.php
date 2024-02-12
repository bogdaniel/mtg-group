<?php

namespace App\Controller;

use App\Entity\ProjectPump;
use App\Form\ProjectPumpType;
use App\Repository\ProjectPumpRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/project/pump')]
class ProjectPumpController extends AbstractController
{
    #[Route('/', name: 'app_project_pump_index', methods: ['GET'])]
    public function index(ProjectPumpRepository $projectPumpRepository): Response
    {
        return $this->render('project_pump/index.html.twig', [
            'project_pumps' => $projectPumpRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_project_pump_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $projectPump = new ProjectPump();
        $form = $this->createForm(ProjectPumpType::class, $projectPump);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($projectPump);
            $entityManager->flush();

            return $this->redirectToRoute('app_project_pump_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project_pump/new.html.twig', [
            'project_pump' => $projectPump,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_project_pump_show', methods: ['GET'])]
    public function show(ProjectPump $projectPump): Response
    {
        return $this->render('project_pump/show.html.twig', [
            'project_pump' => $projectPump,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_project_pump_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ProjectPump $projectPump, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjectPumpType::class, $projectPump);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_project_pump_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project_pump/edit.html.twig', [
            'project_pump' => $projectPump,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_project_pump_delete', methods: ['POST'])]
    public function delete(Request $request, ProjectPump $projectPump, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projectPump->getId(), $request->request->get('_token'))) {
            $entityManager->remove($projectPump);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_project_pump_index', [], Response::HTTP_SEE_OTHER);
    }
}
