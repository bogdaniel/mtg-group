<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Infrastructure\Persistence\Dbal\Types;

use Zenchron\FileManagerBundle\Domain\ValueObject\MediaId;
use Zenchron\SharedBundle\Infrastructure\Persistence\Dbal\Types\UlidType;

class MediaIdType extends UlidType
{
    protected function getClass(): string
    {
        return MediaId::class;
    }
}
