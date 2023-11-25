<?php
declare(strict_types=1);

namespace App\FileManager\Infrastructure\Persistence\Dbal\Types;

use App\FileManager\Domain\ValueObject\MediaId;
use App\Shared\Infrastructure\Persistence\Dbal\Types\UlidType;

class MediaIdType extends UlidType
{
    protected function getClass(): string
    {
        return MediaId::class;
    }
}
