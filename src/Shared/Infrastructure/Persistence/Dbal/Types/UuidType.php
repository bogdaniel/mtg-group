<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Dbal\Types;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Shared\Domain\ValueObject\UuidValueObject;

abstract class UuidType extends BaseUidType
{
    /**
     * @param $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return UuidValueObject|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?UuidValueObject
    {
        if ($value instanceof UuidValueObject || null === $value) {
            return $value;
        }

        $className = $this->getClass();
        /** @var \App\Shared\Domain\ValueObject\UuidValueObject $className */

        return $className::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        $toString = $this->hasNativeGuidType($platform) ? 'toRfc4122' : 'toBinary';

        if ($value instanceof UuidValueObject) {
            return $value->$toString();
        }

        if (null === $value || '' === $value) {
            return null;
        }

        $className = $this->getClass();
        /** @var UuidValueObject $className */
        $value = $className::fromString($value);

        return $value->$toString();
    }
}
