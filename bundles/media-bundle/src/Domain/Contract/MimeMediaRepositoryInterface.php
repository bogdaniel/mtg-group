<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\Contract;


use Zenchron\FileManagerBundle\Domain\Model\Media;

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
