<?php

namespace App\Service;

use App\Entity\FileEntity;
use App\Repository\FileRepository;

class FileManager
{
    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function createFile(FileEntity $file, bool $convertToMp4 = false, bool $encrypt = false): void
    {
        // TODO: Add logic to handle file upload and conversion to MP4 if necessary
        // TODO: Add logic to handle file encryption if necessary

        $this->fileRepository->create($file);
    }

    public function getFile(int $id): ?FileEntity
    {
        return $this->fileRepository->read($id);
    }

    public function updateFile(FileEntity $file, array $metadata): void
    {
        // TODO: Add logic to handle file update and metadata storage

        $this->fileRepository->update($file);
    }

    public function deleteFile(FileEntity $file, bool $softDelete = false): void
    {
        if ($softDelete) {
            // TODO: Add logic to handle soft delete
        } else {
            $this->fileRepository->delete($file);
        }
    }

    public function enableFeature(FileEntity $file, string $feature): void
    {
        // TODO: Add logic to enable a feature for a file
    }

    public function disableFeature(FileEntity $file, string $feature): void
    {
        // TODO: Add logic to disable a feature for a file
    }
}
