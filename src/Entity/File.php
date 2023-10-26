<?php

namespace App\Entity;

use App\Domain\Entity\FileData;
use App\Repository\FileRepository;

class File
{
    public function __construct(
        private FileData $fileData,
        private FileRepository $fileRepository
    ) {}

    // getters and setters
}
