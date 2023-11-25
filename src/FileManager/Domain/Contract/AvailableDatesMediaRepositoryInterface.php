<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Contract;


use App\FileManager\Domain\Model\Media;

interface AvailableDatesMediaRepositoryInterface
{

    /**
     * @return array<Media>
     */
    public function getAll(): array;
}
