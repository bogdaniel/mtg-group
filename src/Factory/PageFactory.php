<?php

namespace App\Factory;

use App\Entity\Page;

class PageFactory
{
    public function create(): Page
    {
        return new Page();
    }
}
