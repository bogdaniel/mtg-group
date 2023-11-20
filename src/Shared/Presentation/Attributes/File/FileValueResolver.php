<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Attributes\File;

use App\Shared\Application\Contract\RequestDataTransferObjectContract;
use App\Shared\Presentation\Attributes\AttributeValidator;
use App\Shared\Infrastructure\Validator\RequestAttributeValidator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\InvalidMetadataException;


class FileValueResolver implements ArgumentValueResolverInterface
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

        return $argument->getAttributes()[0] instanceof File
            && \is_a($argument->getType(), RequestDataTransferObjectContract::class, true);
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return iterable<RequestDataTransferObjectContract|null>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$file = $request->files->get('file')) {
            yield null;

            return;
        }
        if (!$file instanceof UploadedFile) {
            yield null;

            return;
        }

        $data = [
            'path' => $file->getRealPath(),
            'name' => $file->getClientOriginalName(),
            'mime' => $file->getMimeType() ?? $file->getClientMimeType(),
            'extension' => $file->guessExtension() ?? $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
        ];

        /* @var class-string<RequestDataTransferObjectContract> $type */
        if (!$type = $argument->getType()) {
            throw new InvalidMetadataException(
                'The argument type not found in the FileValueResolver class'
            );
        }
        /** @var array<File> $attributes */
        $attributes = $argument->getAttributes();

        $attributeValidator = new AttributeValidator(
            $type,
            $attributes[0]->getConstraint(),
            $attributes[0]->getGroups()
        );

        yield $this->dtoValidatorResolver->validate($attributeValidator, $data);
    }
}
