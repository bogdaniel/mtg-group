<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;
use App\Repository\ThemeRepository;

#[Entity(repositoryClass: ThemeRepository::class)]
class Theme
{
    #[Id, GeneratedValue, Column(type: "integer")]
    private $id;

    #[Column(type: "string", length: 255)]
    private $name;

    #[Column(type: "string", length: 255)]
    private $description;

    #[Column(type: "string", length: 255)]
    private $author;

    // getters and setters...
}
