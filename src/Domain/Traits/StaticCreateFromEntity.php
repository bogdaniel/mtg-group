<?php

namespace App\Domain\Traits;

use App\Domain\Entity\ThemeData;
use App\Entity\Theme;

trait StaticCreateFromEntity
{
    public static function createFromEntity(Theme $entity): ThemeData
    {
        $themeData = new ThemeData(
            $entity->name,
            $entity->title,
            $entity->description,
            $entity->license,
            $entity->authors,
            $entity->version,
            $entity->homepage,
            $entity->isActive,
            $entity->parentTheme
        );

        return $themeData;
    }
}
