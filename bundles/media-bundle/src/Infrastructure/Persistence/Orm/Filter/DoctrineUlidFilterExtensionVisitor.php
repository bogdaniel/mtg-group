<?php

declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Infrastructure\Persistence\Orm\Filter;


use Zenchron\FileManagerBundle\Domain\Model\Media;
use Zenchron\FileManagerBundle\Domain\ValueObject\MediaId;
use Zenchron\SharedBundle\Filter\ConditionFilter;
use Zenchron\SharedBundle\Filter\Criteria;
use Zenchron\SharedBundle\Filter\Driver;
use Zenchron\SharedBundle\Filter\Visitor\Extension\FilterExtensionVisitor;
use Zenchron\SharedBundle\Infrastructure\Persistence\Orm\UidMapperPlatform;

class DoctrineUlidFilterExtensionVisitor implements FilterExtensionVisitor
{

    public function __construct(private readonly UidMapperPlatform $uidMapperPlatform)
    {
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function visit(ConditionFilter $filter, Criteria $criteria): ConditionFilter
    {
        $value = $filter->value();
        if (!$value instanceof MediaId) {
            return $filter;
        }

        $expression = \sprintf('%s = %s', $filter->field(), ':ulid');
        $filter->expression()->setExpression($expression);
        $filter->expression()->setParameters([
            ':ulid' => $this->uidMapperPlatform->convertToDatabaseValue($value),
        ]);


        return $filter;
    }

    public function support(ConditionFilter $filter, Criteria $criteria): bool
    {
        return $filter->field() === 'm.id'
            && \is_a($criteria::modelClass(), Media::class, true);
    }

    public static function driver(): string
    {
        return Driver::DOCTRINE_ORM->value;
    }
}
