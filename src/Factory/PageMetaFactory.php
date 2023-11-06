<?php

namespace App\Factory;

use App\Entity\PageMeta;

class PageMetaFactory
{
    public function create(): PageMeta
    {
        return new PageMeta();
    }
}
