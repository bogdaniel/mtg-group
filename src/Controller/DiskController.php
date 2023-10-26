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
        // TODO: Add logic to handle the request and create a new Disk

        return $this->redirectToRoute('disk_index');
    }

    /**
     * @Route("/disk/{id}", name="disk_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $disk = $this->diskManager->getDisk($id);

        // TODO: Add logic to handle the request and show a Disk

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

        // TODO: Add logic to handle the request and edit a Disk

        return $this->redirectToRoute('disk_index');
    }

    /**
     * @Route("/disk/{id}", name="disk_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $disk = $this->diskManager->getDisk($id);
        $this->diskManager->deleteDisk($disk);

        return $this->redirectToRoute('disk_index');
    }
}
