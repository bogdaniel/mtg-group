<?php

namespace App\Attribute;

use Attribute;
use Symfony\Component\Routing\Annotation\Route;

#[Attribute]
class Delete extends Route
{
    public function getMethods()
    {
        return [HttpMethod::DELETE->name];
    }
}
