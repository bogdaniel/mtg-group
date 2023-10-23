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

                // Get the type of the property from the entity
                $propertyType = $property->getType();
                if ($propertyType) {
                    $propertyType = $propertyType->getName();

                    if (interface_exists($propertyType)) {

                        // If the property value is an object that is an instance of the same class or implements the same interface, recursively call createFromEntity
                        if (is_object($propertyValue) && (is_a($propertyValue, $propertyType) || in_array($propertyType, class_implements($propertyValue)))) {
                            $propertyValue = static::createFromEntity($propertyValue);
                        }
                    }
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
