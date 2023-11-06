<?php

namespace App\Entity;

use App\Doctrine\Type\PageStatusType;
use App\Entity\Contract\PageEntityContract;
use App\Enum\PageStatusEnum;
use App\Repository\PageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page implements PageEntityContract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public readonly int $id;

    public function __construct(
        #[ORM\Column(length: 500)] public ?string $name = null,
        #[ORM\OneToOne(mappedBy: 'page', cascade: ['persist', 'remove'])] public ?PageMeta $pageMeta = null,
        #[ORM\Column(type:  PageStatusType::NAME)] public PageStatusEnum $status = PageStatusEnum::AUTO_DRAFT,
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
