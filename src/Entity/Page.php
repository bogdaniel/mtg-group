<?php

namespace App\Entity;

use App\Entity\Contract\PageEntityContract;
use App\Repository\PageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page implements PageEntityContract
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column] public ?int $id = null,
        #[ORM\Column(length: 500)] public ?string $name = null,
        #[ORM\OneToOne(mappedBy: 'page', cascade: ['persist', 'remove'])] public ?PageMeta $pageMeta = null,
        #[ORM\Column(type: 'PostStatus')] public PostStatus $status = PostStatus::AUTO_DRAFT,
        #[ORM\Column(type: Types::SMALLINT)] public ?int $type = null
    ) {}
    public function setPageMeta(PageMeta $pageMeta): static
    {
        // set the owning side of the relation if necessary
        if ($pageMeta->page !== $this) {
            $pageMeta->page = $this;
        }

        $this->pageMeta = $pageMeta;

        return $this;
    }
}
