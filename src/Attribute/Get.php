<?php

namespace App\Attribute;

use Attribute;
use Symfony\Component\Routing\Annotation\Route;

#[Attribute]
class Get extends Route
{
    public function getMethods()
    {
        return [HttpMethod::GET->name];
    }

}
