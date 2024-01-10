<?php

declare(strict_types=1);

namespace Zenchron\FileBundle\Infrastructure\Persistence\Orm\Filter;


use Zenchron\FileBundle\Domain\Model\Media;
use Zenchron\SharedBundle\Filter\ConditionFilter;
use Zenchron\SharedBundle\Filter\Criteria;
use Zenchron\SharedBundle\Filter\Driver;
use Zenchron\SharedBundle\Filter\Visitor\Extension\FilterExtensionVisitor;

class DoctrineYearMonthDateFilterExtensionVisitor implements FilterExtensionVisitor
{

    public function visit(ConditionFilter $filter, Criteria $criteria): ConditionFilter
    {
        \preg_match('/^(?<year>\d{4})-(?<month>\d{1,2})$/', $filter->value(), $date);

        if (!isset($date['year'], $date['month'])) {
            throw new \InvalidArgumentException(
                'Invalid date format. Required year-month format. Example: 2021-01'
            );
        }

        $expression = \sprintf('YEAR(%1$s)=%2$s and MONTH(%1$s)=%3$s', $filter->field(), ':year', ':month');

        $filter->expression()->setExpression($expression);
        $filter->expression()->setParameters([
            ':year' => $date['year'],
            ':month' => $date['month'],
        ]);

        return $filter;
    }

    public function support(ConditionFilter $filter, Criteria $criteria): bool
    {
        return $filter->field() === 'm.createdAt'
            && \is_a($criteria::modelClass(), Media::class, true);
    }

    public static function driver(): string
    {
        return Driver::DOCTRINE_ORM->value;
    }
}
