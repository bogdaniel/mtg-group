<?php

namespace App\Domain\Traits;

trait ToArray
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
