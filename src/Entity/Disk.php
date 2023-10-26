<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: "App\Repository\DiskRepository")]
class Disk
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    private $name;

    #[ORM\Column(type: "string", length: 255)]
    private $path;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="File", mappedBy="disk")
     */
    private $files;

    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    // getters and setters
}
