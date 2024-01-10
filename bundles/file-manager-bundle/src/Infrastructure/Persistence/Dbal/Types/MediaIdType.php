<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Infrastructure\Persistence\Dbal\Types;

use Zenchron\SharedBundle\Infrastructure\Persistence\Dbal\Types\UlidType;
use Zenchron\FileBundle\Domain\ValueObject\MediaId;

class MediaIdType extends UlidType
{
    protected function getClass(): string
    {
        return MediaId::class;
    }
}
