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

    // TODO: Add methods for create, read, update, and delete operations
}
