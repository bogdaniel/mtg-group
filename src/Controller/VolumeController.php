<?php

namespace App\Controller;

use App\Service\VolumeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VolumeController extends AbstractController
{
    private VolumeManager $volumeManager;

    public function __construct(VolumeManager $volumeManager)
    {
        $this->volumeManager = $volumeManager;
    }

    /**
     * @Route("/volume", name="volume_index", methods={"GET"})
     */
    public function index(): Response
    {
        $volumes = $this->volumeManager->getAllVolumes();

        return $this->render('volume/index.html.twig', [
            'volumes' => $volumes,
        ]);
    }

    // TODO: Add methods for create, read, update, and delete operations
}
