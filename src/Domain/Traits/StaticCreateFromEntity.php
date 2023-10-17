<?php

namespace App\Domain\Traits;

use App\Domain\Entity\ThemeData;
use App\Entity\Theme;

trait StaticCreateFromEntity
{
    public static function createFromEntity(object $entity): object
    {
        $dataClass = get_called_class();
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
