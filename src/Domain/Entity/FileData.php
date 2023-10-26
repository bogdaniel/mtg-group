<?php

namespace App\Domain\Entity;

class FileData
{
    public function __construct(
        private int $id,
        private string $name,
        private int $size,
        private string $mimeType,
        private string $checksum,
        private array $metadata,
        private \DateTimeInterface $createDate,
        private \DateTimeInterface $updateDate,
        private ?\DateTimeInterface $deleteDate,
        private VolumeData $volume,
        private DiskData $disk,
        private string $filename,
        private bool $convertToMp4,
        private bool $encrypt,
        private int $readCount,
        private int $downloadCount,
        private int $editCount,
        private UserContract $lastEditedBy,
        private array $stats
    ) {}

    // getters and setters
}
