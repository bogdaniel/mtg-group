<?php

namespace App\Service;

use App\Entity\File;
use App\Repository\FileRepository;

class FileManager
{
    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function createFile(File $file): void
    {
        $this->fileRepository->create($file);
    }

    public function getFile(int $id): ?File
    {
        return $this->fileRepository->read($id);
    }

    public function updateFile(File $file): void
    {
        $this->fileRepository->update($file);
    }

    public function deleteFile(File $file): void
    {
        $this->fileRepository->delete($file);
    }
}
