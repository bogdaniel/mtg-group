<?php

namespace App\Entity;

enum PageStatusEnum: int
{
    case INHERIT = 0;
    case AUTO_DRAFT = 1;
    case TRASH = 2;
    case PRIVATE = 3;
    case PENDING = 4;
    case DRAFT = 5;
    case FUTURE = 6;
    case PUBLISH = 7;
    case UNLISTED = 8;
}
