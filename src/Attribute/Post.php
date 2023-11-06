<?php

namespace App\Attribute;

use Attribute;
use Symfony\Component\Routing\Annotation\Route;

#[Attribute]
class Post extends Route
{
    public function getMethods()
    {
        return [HttpMethod::POST->name];
    }
}
