<?php

namespace App\Enum;

use UnitEnum;

enum PageStatusEnum: int
{
    case INHERIT = 0;
    case AUTO_DRAFT = 1;
    case TRASH = 2;
    case PRIVATE = 3;
    case PENDING = 4;
    case DRAFT = 5;
    case FUTURE = 6;
    case PUBLISHED = 7;
    case UNLISTED = 8;

    public static function getCases(): array
    {
        $cases = self::cases();
        return array_map(static fn(UnitEnum $case) => $case->name, $cases);
    }

    public static function getValues(): array
    {
        $cases = self::cases();
        return array_map(static fn(UnitEnum $case) => $case->value, $cases);
    }


}
