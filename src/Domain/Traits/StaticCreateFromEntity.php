<?php
declare(strict_types=1);

namespace App\Domain\Traits;

trait StaticCreateFromEntity
{
    public static function createFromEntity(object $entity): object
    {
        $reflectionEntity = new \ReflectionClass($entity);
        $reflectionDataObject = new \ReflectionClass(static::class);
        $dataObject = $reflectionDataObject->newInstanceWithoutConstructor();

        foreach ($reflectionEntity->getProperties() as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();

            if ($property->isInitialized($entity)) {
                $propertyValue = $property->getValue($entity);

                if ($reflectionDataObject->hasProperty($propertyName)) {
                    if (is_object($propertyValue) && get_class($propertyValue) === get_class($entity)) {
                        $propertyValue = static::createFromEntity($propertyValue);
                    }
                    $reflectionDataObject->getProperty($propertyName)->setValue($dataObject, $propertyValue);
                }
            }
        }

        return $dataObject;
    }
}
