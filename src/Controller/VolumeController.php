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

    /**
     * @Route("/volume/create", name="volume_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        // TODO: Add logic to handle the request and create a new Volume

        return $this->redirectToRoute('volume_index');
    }

    /**
     * @Route("/volume/{id}", name="volume_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $volume = $this->volumeManager->getVolume($id);

        // TODO: Add logic to handle the request and show a Volume

        return $this->render('volume/show.html.twig', [
            'volume' => $volume,
        ]);
    }

    /**
     * @Route("/volume/{id}/edit", name="volume_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, int $id): Response
    {
        $volume = $this->volumeManager->getVolume($id);

        // TODO: Add logic to handle the request and edit a Volume

        return $this->redirectToRoute('volume_index');
    }

    /**
     * @Route("/volume/{id}", name="volume_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $volume = $this->volumeManager->getVolume($id);
        $this->volumeManager->deleteVolume($volume);

        return $this->redirectToRoute('volume_index');
    }
}
