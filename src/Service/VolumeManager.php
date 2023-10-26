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

    public function createVolume(Volume $volume): void
    {
        $this->volumeRepository->create($volume);
    }

    public function getVolume(int $id): ?Volume
    {
        return $this->volumeRepository->read($id);
    }

    public function updateVolume(Volume $volume): void
    {
        $this->volumeRepository->update($volume);
    }

    public function deleteVolume(Volume $volume): void
    {
        $this->volumeRepository->delete($volume);
    }
}
