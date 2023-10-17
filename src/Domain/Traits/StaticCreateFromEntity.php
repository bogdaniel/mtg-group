<?php

namespace App\Domain\Traits;

trait StaticCreateFromEntity
{
    public static function createFromEntity(object $entity): object
    {
        $dataClass = static::class;
        $dataObject = new $dataClass();

        $reflectionEntity = new \ReflectionClass($entity);
        $reflectionDataObject = new \ReflectionClass($dataObject);

        foreach ($reflectionEntity->getProperties() as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $propertyValue = $property->getValue($entity);

            if ($reflectionDataObject->hasProperty($propertyName)) {
                $reflectionDataObject->getProperty($propertyName)->setValue($dataObject, $propertyValue);
            }
        }

        return $dataObject;
    }
}
