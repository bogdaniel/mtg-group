<?php
declare(strict_types=1);

namespace App\Domain\Traits;

trait StaticCreateSelf
{
    public static function create(array $values): self
    {
        $class = new \ReflectionClass(static::class);
        $instance = $class->newInstanceWithoutConstructor();

        foreach ($values as $key => $value) {
            if ($class->hasProperty($key)) {
                $property = $class->getProperty($key);
                $property->setAccessible(true);
                $property->setValue($instance, $value);
            }
        }

        return $instance;
    }
}
