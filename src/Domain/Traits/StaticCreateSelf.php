<?php

namespace App\Domain\Traits;

trait StaticCreateSelf
{
    public static function create(array $values): self
    {
        $class = new \ReflectionClass(self::class);
        $instance = $class->newInstanceWithoutConstructor();

        foreach ($values as $key => $value) {
            if ($class->hasProperty($key)) {
                $property = $class->getProperty($key);
                $property->setValue($instance, $value);
            }
        }

        return $instance;
    }
}
