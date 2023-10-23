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

                // If the property value is an object that implements the same interface, recursively call createFromEntity
                if (is_object($propertyValue) && $propertyValue instanceof SomeInterface) {
                    $propertyValue = static::createFromEntity($propertyValue);
                }

                if ($reflectionDataObject->hasProperty($propertyName)) {
                    $reflectionDataObject->getProperty($propertyName)->setValue($dataObject, $propertyValue);
                }
            }
        }

        return $dataObject;
    }
}
