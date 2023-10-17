<?php

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
                    $reflectionDataObject->getProperty($propertyName)->setValue($dataObject, $propertyValue);
                }
            }
        }

        return $dataObject;
    }
}
