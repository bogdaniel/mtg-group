<?php

namespace App\Attribute;

use Attribute;
use Symfony\Component\Routing\Annotation\Route;

#[Attribute]
class Patch extends Route
{
    public function getMethods()
    {
        return [HttpMethod::PATCH->name];
    }
}
