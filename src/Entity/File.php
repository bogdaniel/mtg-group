<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\FileRepository")]
class File
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    private $name;

    #[ORM\Column(type: "integer")]
    private $size;

    #[ORM\Column(type: "string", length: 255)]
    private $mimeType;

    #[ORM\Column(type: "string", length: 255)]
    private $checksum;

    #[ORM\Column(type: "json")]
    private $metadata;

    #[ORM\Column(type: "datetime")]
    private $createDate;

    #[ORM\Column(type: "datetime")]
    private $updateDate;

    #[ORM\Column(type: "datetime", nullable: true)]
    private $deleteDate;

    #[ORM\ManyToOne(targetEntity: "Volume", inversedBy: "files")]
    private $volume;

    #[ORM\ManyToOne(targetEntity: "Disk", inversedBy: "files")]
    private $disk;

    #[ORM\Column(type: "string", length: 255)]
    private $filename;

    #[ORM\Column(type: "boolean")]
    private $convertToMp4;

    #[ORM\Column(type: "boolean")]
    private $encrypt;

    // getters and setters
}
