<?php

namespace App\Controller;

use App\Entity\Disk;
use App\Service\DiskManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiskController extends AbstractController
{
    private DiskManager $diskManager;

    public function __construct(DiskManager $diskManager)
    {
        $this->diskManager = $diskManager;
    }

    /**
     * @Route("/disk", name="disk_index", methods={"GET"})
     */
    public function index(): Response
    {
        $disks = $this->diskManager->getAllDisks();

        return $this->render('disk/index.html.twig', [
            'disks' => $disks,
        ]);
    }

    /**
     * @Route("/disk/create", name="disk_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $disk = new Disk();
        $form = $this->createForm(DiskType::class, $disk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->diskManager->createDisk($disk);

            return $this->redirectToRoute('disk_index');
        }

        return $this->render('disk/new.html.twig', [
            'disk' => $disk,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/disk/{id}", name="disk_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $disk = $this->diskManager->getDisk($id);

        if (!$disk) {
            throw $this->createNotFoundException('The disk does not exist');
        }

        return $this->render('disk/show.html.twig', [
            'disk' => $disk,
        ]);
    }

    /**
     * @Route("/disk/{id}/edit", name="disk_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, int $id): Response
    {
        $disk = $this->diskManager->getDisk($id);

        if (!$disk) {
            throw $this->createNotFoundException('The disk does not exist');
        }

        $form = $this->createForm(DiskType::class, $disk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->diskManager->updateDisk($disk);

            return $this->redirectToRoute('disk_index');
        }

        return $this->render('disk/edit.html.twig', [
            'disk' => $disk,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/disk/{id}", name="disk_delete", methods={"DELETE"})
     */
    public function delete(Request $request, int $id): Response
    {
        $disk = $this->diskManager->getDisk($id);

        if (!$disk) {
            throw $this->createNotFoundException('The disk does not exist');
        }

        if ($this->isCsrfTokenValid('delete'.$disk->getId(), $request->request->get('_token'))) {
            $this->diskManager->deleteDisk($disk);
        }

        return $this->redirectToRoute('disk_index');
    }
}
