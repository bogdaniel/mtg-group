<?php

namespace App\Service;

use App\Repository\DiskRepository;

class DiskService
{
    private DiskRepository $diskRepository;

    public function __construct(DiskRepository $diskRepository)
    {
        $this->diskRepository = $diskRepository;
    }

    // Add methods for creating, reading, updating, and deleting Disk records
}
