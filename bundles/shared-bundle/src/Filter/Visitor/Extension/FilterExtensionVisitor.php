<?php
declare(strict_types=1);

namespace Zenchron\SharedBundle\Filter\Visitor\Extension;

use Zenchron\SharedBundle\Filter\ConditionFilter;
use Zenchron\SharedBundle\Filter\Criteria;

interface FilterExtensionVisitor
{
    public const TAG_NAME = 'zenchron.filter_extension_visitor';

    /**
     * @param \Zenchron\SharedBundle\Filter\ConditionFilter $filter
     * @param \Zenchron\SharedBundle\Filter\Criteria $criteria
     * @return \Zenchron\SharedBundle\Filter\ConditionFilter
     */
    public function visit(ConditionFilter $filter, Criteria $criteria): ConditionFilter;

    /***
     * @param \Zenchron\SharedBundle\Filter\ConditionFilter $filter
     * @param \Zenchron\SharedBundle\Filter\Criteria $criteria
     * @return bool
     */
    public function support(ConditionFilter $filter, Criteria $criteria): bool;

    public static function driver(): string;
}
