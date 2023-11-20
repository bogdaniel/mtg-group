<?php
declare(strict_types=1);

namespace App\Shared\Filter\Visitor\Extension;

use App\Shared\Filter\ConditionFilter;
use App\Shared\Filter\Criteria;

interface FilterExtensionVisitor
{
    public const TAG_NAME = 'ranky.filter_extension_visitor';

    /**
     * @param \App\Shared\Filter\ConditionFilter $filter
     * @param \App\Shared\Filter\Criteria $criteria
     * @return \App\Shared\Filter\ConditionFilter
     */
    public function visit(ConditionFilter $filter, Criteria $criteria): ConditionFilter;

    /***
     * @param \App\Shared\Filter\ConditionFilter $filter
     * @param \App\Shared\Filter\Criteria $criteria
     * @return bool
     */
    public function support(ConditionFilter $filter, Criteria $criteria): bool;

    public static function driver(): string;
}
