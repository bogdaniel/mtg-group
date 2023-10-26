<?php

namespace App\Service;

use App\Repository\VolumeRepository;

class VolumeManager
{
    private VolumeRepository $volumeRepository;

    public function __construct(VolumeRepository $volumeRepository)
    {
        $this->volumeRepository = $volumeRepository;
    }

    public function getAllVolumes(): array
    {
        return $this->volumeRepository->findAll();
    }

    // TODO: Add methods for create, read, update, and delete operations
}
