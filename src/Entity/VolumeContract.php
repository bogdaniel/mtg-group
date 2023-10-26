<?php

namespace App\Entity;

interface VolumeContract
{
    public function getId(): ?int;
    public function getName(): ?string;
    public function getFiles(): ArrayCollection;
}
