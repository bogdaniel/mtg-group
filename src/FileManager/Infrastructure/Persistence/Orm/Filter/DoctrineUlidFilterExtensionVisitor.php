<?php

declare(strict_types=1);

namespace App\FileManager\Infrastructure\Persistence\Orm\Filter;


use App\FileManager\Domain\Model\Media;
use App\FileManager\Domain\ValueObject\MediaId;
use App\Shared\Filter\ConditionFilter;
use App\Shared\Filter\Criteria;
use App\Shared\Filter\Driver;
use App\Shared\Filter\Visitor\Extension\FilterExtensionVisitor;
use App\Shared\Infrastructure\Persistence\Orm\UidMapperPlatform;

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
