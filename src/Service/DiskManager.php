<?php

namespace App\Service;

use App\Entity\Disk;
use App\Repository\DiskRepository;

class DiskManager
{
    private DiskRepository $diskRepository;

    public function __construct(DiskRepository $diskRepository)
    {
        $this->diskRepository = $diskRepository;
    }

    public function getAllDisks(): array
    {
        return $this->diskRepository->findAll();
    }

    public function create(Disk $disk): void
    {
        $this->diskRepository->create($disk);
    }

    public function read(int $id): ?Disk
    {
        return $this->diskRepository->read($id);
    }

    public function update(Disk $disk): void
    {
        $this->diskRepository->update($disk);
    }

    public function delete(Disk $disk): void
    {
        $this->diskRepository->delete($disk);
    }}
