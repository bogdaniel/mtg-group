<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Validator;

use App\Shared\Application\Contract\RequestDataTransferObjectContract;
use App\Shared\Presentation\Attributes\AttributeValidator;
use App\Shared\Common\ClassHelper;
use App\Shared\Domain\Exception\ApiProblem\ApiProblem;
use App\Shared\Domain\Exception\ApiProblem\ValidationFailedException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class RequestAttributeValidator
{

    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param AttributeValidator $attributeValidator
     * @param array<string, mixed> $data
     * @return RequestDataTransferObjectContract
     */
    public function validate(AttributeValidator $attributeValidator, array $data): RequestDataTransferObjectContract
    {
        /** @var  \App\Shared\Application\Dto\RequestDataTransferObjectContract $requestDtoClass */
        $requestDtoClass = ($attributeValidator->type());
        $requestDtoObject = $requestDtoClass::fromRequest($data);
        if (!$attributeValidator->constraint()) {
            return $requestDtoObject;
        }

        /**
         * TODO: Create interface For ...ValidationConstraint
         * @phpstan-ignore-next-line
         */
        $constraints = (new ($attributeValidator->constraint()))->__invoke();
        $propertiesToValidate = \array_keys($constraints);

        $data = \array_filter(
            $data,
            static fn($key) => in_array($key, $propertiesToValidate, true),
            ARRAY_FILTER_USE_KEY,
        );

        $constraintViolationList = $this->validator->validate(
            $data,
            new Assert\Collection($constraints),
            $attributeValidator->groups() ?? RequestDataTransferObjectContract::DEFAULT_VALIDATION_GROUP,
        );

        if (count($constraintViolationList) > 0) {
            $errorTitle = \sprintf('%s validation failed', ClassHelper::className($requestDtoClass));
            $apiProblem = new ApiProblem($errorTitle);
            /** @var ConstraintViolationInterface $violation */
            foreach ($constraintViolationList as $violation) {
                $apiProblem->addCause((string)$violation->getPropertyPath(), (string)$violation->getMessage());
            }
            throw new ValidationFailedException($apiProblem);
        }

        return $requestDtoObject;
    }

}
