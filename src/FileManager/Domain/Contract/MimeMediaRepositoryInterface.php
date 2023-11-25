<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Contract;


use App\FileManager\Domain\Model\Media;

interface MimeMediaRepositoryInterface
{

    /**
     * @return array<Media>
     */
    public function getAll(): array;

    /**
     * @return array<Media>
     */
    public function getAllByType(): array;

    /**
     * @return array<Media>
     */
    public function getAllBySubType(): array;
}
