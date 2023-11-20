<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Dbal\Types;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Shared\Domain\ValueObject\UlidValueObject;

abstract class UlidType extends BaseUidType
{
    /**
     * @param $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return UlidValueObject|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?UlidValueObject
    {
        if ($value instanceof UlidValueObject || null === $value) {
            return $value;
        }

        $className = $this->getClass();
        /** @var \App\Shared\Domain\ValueObject\UlidValueObject $className */

        return $className::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        $toString = $this->hasNativeGuidType($platform) ? 'toRfc4122' : 'toBinary';

        if ($value instanceof UlidValueObject) {
            return $value->$toString();
        }

        if (null === $value || '' === $value) {
            return null;
        }

        $className = $this->getClass();
        /** @var UlidValueObject $className */
        $value = $className::fromString($value);

        return $value->$toString();
    }
}
