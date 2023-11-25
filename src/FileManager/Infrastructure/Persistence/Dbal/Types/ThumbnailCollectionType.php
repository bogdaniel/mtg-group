<?php
declare(strict_types=1);

namespace App\FileManager\Infrastructure\Persistence\Dbal\Types;


use App\FileManager\Domain\ValueObject\Thumbnails;
use App\Shared\Infrastructure\Persistence\Dbal\Types\JsonCollectionType;

/**
 * @template-extends JsonCollectionType<Thumbnails>
 */
final class ThumbnailCollectionType extends JsonCollectionType
{
    public const NAME = 'thumbnail_collection';

    protected function fieldName(): string
    {
        return self::NAME;
    }

    protected function collectionClass(): string
    {
        return Thumbnails::class;
    }

}
