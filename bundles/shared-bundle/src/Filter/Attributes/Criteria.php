<?php
declare(strict_types=1);

namespace Zenchron\SharedBundle\Filter\Attributes;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_PARAMETER)]
class Criteria
{

    public function __construct(private readonly ?int $paginationLimit = null)
    {
    }

    public function getPaginationLimit(): ?int
    {
        return $this->paginationLimit;
    }

}
