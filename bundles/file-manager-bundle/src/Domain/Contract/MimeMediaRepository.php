<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Domain\Contract;


use Zenchron\FileBundle\Domain\Model\Media;

interface MimeMediaRepository
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
