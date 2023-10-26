<?php

namespace App\Controller;

use App\Service\FileManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    private FileManager $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * @Route("/file/create", name="file_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        // TODO: Add logic to handle the request and create a new FileEntity

        return $this->redirectToRoute('file_index');
    }

    /**
     * @Route("/file/{id}", name="file_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $file = $this->fileManager->getFile($id);

        // TODO: Add logic to handle the request and show a FileEntity

        return $this->render('file/show.html.twig', [
            'file' => $file,
        ]);
    }

    /**
     * @Route("/file/{id}/edit", name="file_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, int $id): Response
    {
        $file = $this->fileManager->getFile($id);

        // TODO: Add logic to handle the request and edit a FileEntity

        return $this->redirectToRoute('file_index');
    }

    /**
     * @Route("/file/{id}", name="file_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $file = $this->fileManager->getFile($id);
        $this->fileManager->deleteFile($file);

        return $this->redirectToRoute('file_index');
    }
}
