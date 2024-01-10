<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Infrastructure\Persistence\Dbal\Types;


use Zenchron\FileBundle\Domain\ValueObject\Thumbnails;
use Zenchron\SharedBundle\Infrastructure\Persistence\Dbal\Types\JsonCollectionType;

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
