<?php

namespace App\Doctrine\Type;

use App\Doctrine\AbstractEnumType;
use App\Enum\PageStatusEnum;

class PageStatusType extends AbstractEnumType
{
    public const NAME = 'pageStatusType';

    public static function getEnumsClass(): string
    {
        return PageStatusEnum::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
