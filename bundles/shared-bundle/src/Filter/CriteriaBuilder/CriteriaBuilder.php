<?php

declare(strict_types=1);

namespace Zenchron\SharedBundle\Filter\CriteriaBuilder;

use Zenchron\SharedBundle\Filter\Visitor\FilterVisitor;

interface CriteriaBuilder
{
    /**
     * @param FilterVisitor $filterVisitor
     * @return $this
     *
     */
    public function addFilterVisitor(FilterVisitor $filterVisitor): self;

    public function where(): self;

    public function withLimit(): self;

    public function withOrder(): self;

    public function getQuery(): mixed;
}
