<?php

namespace App\Attribute;

use Attribute;
use Symfony\Component\Routing\Annotation\Route;

#[Attribute]
class Put extends Route
{
    public function getMethods()
    {
        return [HttpMethod::PUT->name];
    }
}
