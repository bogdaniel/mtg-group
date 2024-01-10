<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Domain\Contract;


use Zenchron\FileBundle\Domain\Model\Media;

interface AvailableDatesMediaRepository
{

    /**
     * @return array<Media>
     */
    public function getAll(): array;
}
