<?php

namespace App\Entity;

use App\Repository\PageMetaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageMetaRepository::class)]
class PageMeta
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column] public ?int $id = null,
        #[ORM\Column(length: 255)] public ?string $title = null,
        #[ORM\Column(length: 500)] public ?string $slug = null,
        #[ORM\Column(length: 60)] public ?string $metaTitle = null,
        #[ORM\Column(length: 160)] public ?string $metaDescription = null,
        #[ORM\OneToOne(inversedBy: 'pageMeta', cascade: ['persist', 'remove'])]
        #[ORM\JoinColumn(nullable: false)] public ?Page $page = null
    ) {
    }
}
