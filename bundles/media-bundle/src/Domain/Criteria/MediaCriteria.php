<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\Criteria;

use Zenchron\FileManagerBundle\Domain\Model\Media;
use Zenchron\FileManagerBundle\Domain\ValueObject\MediaId;
use Zenchron\SharedBundle\Filter\Criteria;

class MediaCriteria extends Criteria
{
    public const MODEL_ALIAS              = 'm';
    public const DEFAULT_PAGINATION_LIMIT = 30;
    public const DEFAULT_PAGINATION_RANGE = 2;
    public const DEFAULT_ORDER_FIELD      = 'createdAt';
    public const DEFAULT_ORDER_DIRECTION  = 'DESC';

    public static function normalizeNameFields(): array
    {
        return [
            'id'        => 'm.id',
            'mime'      => 'm.file.mime',
            'name'      => 'm.file.name',
            'createdAt' => 'm.createdAt',
            'createdBy' => 'm.createdBy',
        ];
    }

    public static function normalizeValues(): array
    {
        return [
            'id' => static function (mixed $value) {
                if ($value instanceof MediaId) {
                    return $value;
                }
                if (\str_contains($value, ',')) {
                    return \array_map(
                        static fn (string $mediaId) => MediaId::fromString($mediaId),
                        \explode(',', $value)
                    );
                }

                return MediaId::fromString($value);
            },
        ];
    }

    public static function modelClass(): string
    {
        return Media::class;
    }

    public static function modelAlias(): string
    {
        return self::MODEL_ALIAS;
    }
}
