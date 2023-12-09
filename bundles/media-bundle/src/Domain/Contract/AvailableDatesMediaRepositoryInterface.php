<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\Contract;


use Zenchron\FileManagerBundle\Domain\Model\Media;

interface AvailableDatesMediaRepositoryInterface
{

    /**
     * @return array<Media>
     */
    public function getAll(): array;
}
