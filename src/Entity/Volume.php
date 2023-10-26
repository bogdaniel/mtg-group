<?php

namespace App\Entity;

use App\Domain\Entity\VolumeData;
use App\Repository\VolumeRepository;

class Volume
{
    private VolumeData $volumeData;
    private VolumeRepository $volumeRepository;

    public function __construct(VolumeData $volumeData, VolumeRepository $volumeRepository)
    {
        $this->volumeData = $volumeData;
        $this->volumeRepository = $volumeRepository;
    }

    // getters and setters
}
