<?php

namespace App\Attribute;

use Attribute;
use Symfony\Component\Routing\Annotation\Route;

#[Attribute]
class Options extends Route
{
    public function getMethods()
    {
        return [HttpMethod::OPTIONS->name];
    }

}
