<?php

namespace App\DataTransferObject;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProjectFileUploadDataTransfer
{
    private ?UploadedFile $file = null;

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    public function setFile(?UploadedFile $file): self
    {
        $this->file = $file;
        return $this;
    }

}
