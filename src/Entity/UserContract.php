<?php

namespace App\Entity;

interface UserContract
{
    public function getId(): ?int;
    public function getUsername(): ?string;
    public function getPassword(): ?string;
}
