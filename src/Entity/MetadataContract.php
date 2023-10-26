<?php

namespace App\Entity;

interface MetadataContract
{
    public function getId(): ?int;
    public function getKey(): ?string;
    public function getValue(): ?string;
}
