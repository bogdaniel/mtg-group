<?php

namespace App\Entity;

interface OperatorContract
{
    public function getId(): ?int;
    public function getName(): ?string;
}
