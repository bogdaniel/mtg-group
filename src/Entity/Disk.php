<?php

namespace App\Entity;

use App\Domain\Entity\DiskData;
use App\Repository\DiskRepository;

class Disk
{
    private DiskData $diskData;
    private DiskRepository $diskRepository;

    public function __construct(DiskData $diskData, DiskRepository $diskRepository)
    {
        $this->diskData = $diskData;
        $this->diskRepository = $diskRepository;
    }

    // getters and setters
}
