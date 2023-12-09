<?php
declare(strict_types=1);

namespace Zenchron\SharedBundle\Filter\Exception;


use Zenchron\SharedBundle\Domain\Exception\HttpDomainException;
use Zenchron\SharedBundle\Filter\ConditionOperator;
use Zenchron\SharedBundle\Filter\CompositeOperator;

final class OperatorException extends HttpDomainException
{

    public static function notValidFilterOperator(string $operator): self
    {
        return new self(
            \sprintf(
                'The "%s" filter operator is not valid. List of valid operators: %s.',
                $operator,
                \implode(', ', ConditionOperator::operators())
            ),
            400
        );
    }

    public static function notValidLogicOperator(string $operator): self
    {
        return new self(
            \sprintf(
                'The "%s" logic operator is not valid. List of valid operators: %s.',
                $operator,
                \implode(', ', CompositeOperator::operators())
            ),
            400
        );
    }
}
