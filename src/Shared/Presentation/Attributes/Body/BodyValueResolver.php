<?php
declare(strict_types=1);

namespace App\Shared\Presentation\Attributes\Body;

use App\Shared\Application\Contract\RequestDataTransferObjectContract;
use App\Shared\Presentation\Attributes\AttributeValidator;
use App\Shared\Infrastructure\Validator\RequestAttributeValidator;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\InvalidMetadataException;

use function is_a;
use function json_decode;

class BodyValueResolver implements ArgumentValueResolverInterface
{

    private RequestAttributeValidator $dtoValidatorResolver;

    public function __construct(RequestAttributeValidator $dtoValidatorResolver)
    {
        $this->dtoValidatorResolver = $dtoValidatorResolver;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (!$argument->getAttributes() || null === $argument->getType()) {
            return false;
        }

        return $argument->getAttributes()[0] instanceof Body
            && is_a($argument->getType(), RequestDataTransferObjectContract::class, true);
    }


    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @throws JsonException
     * @return iterable<RequestDataTransferObjectContract>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {

        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        /* @var class-string<RequestDataTransferObjectContract> $type */
        if (!$type = $argument->getType()) {
            throw new InvalidMetadataException(
                'The argument type not found in the BodyValueResolver class'
            );
        }

        /** @var array<Body> $attributes */
        $attributes = $argument->getAttributes();

        $attributeValidator = new AttributeValidator(
            $type,
            $attributes[0]->getConstraint(),
            $attributes[0]->getGroups()
        );

        yield $this->dtoValidatorResolver->validate($attributeValidator, $data);

        //yield $this->serializer->deserialize($requestFilterData, $argument->getType(), $request->getContentType());

    }
}
