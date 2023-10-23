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

                // Check if the property in the data object has a type hint of an interface
                if ($reflectionDataObject->hasProperty($propertyName)) {
                    $reflectionProperty = $reflectionDataObject->getProperty($propertyName);
                    $reflectionType = $reflectionProperty->getType();
                    if ($reflectionType && $reflectionType->isBuiltin()) {
                        $reflectionProperty->setValue($dataObject, $propertyValue);
                    }
                }
            }
        }

        return $dataObject;
    }
}
