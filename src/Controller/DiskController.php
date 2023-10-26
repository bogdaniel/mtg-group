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

    // TODO: Add methods for create, read, update, and delete operations
}
