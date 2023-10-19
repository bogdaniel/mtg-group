<?php
declare(strict_types=1);

namespace App\Domain\Traits;

trait ToEntity
{
    public function toEntity(string $entityClass)
    {
        $entity = new $entityClass();

        foreach ($this as $property => $value) {
            if (property_exists($entity, $property)) {
                $entity->$property = $value;
            }
        }

        return $entity;
    }
}
