<?php

declare(strict_types=1);


namespace Zenchron\FileBundle\Presentation\Form\DataTransformer;

use Zenchron\FileBundle\Domain\Contract\MediaRepository;
use Zenchron\FileBundle\Domain\Model\Media;
use Zenchron\FileBundle\Domain\ValueObject\MediaId;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class MediaEntityTransformer implements DataTransformerInterface
{
    public function __construct(private readonly MediaRepository $mediaRepository)
    {
    }

    public function transform(mixed $value): ?string
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof Media) {
            throw new TransformationFailedException(
                \sprintf(
                    'Expected a Media instance. %s type given',
                    gettype($value)
                )
            );
        }

        return (string)$value->id();
    }

    public function reverseTransform(mixed $value): ?Media
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if (!\is_string($value)) {
            throw new TransformationFailedException(
                \sprintf(
                    'Expected a string id. %s type given',
                    gettype($value)
                )
            );
        }

        try {
            return $this->mediaRepository->getById(MediaId::fromString($value));
        } catch (\Throwable $e) {
            throw new TransformationFailedException(
                sprintf('The value "%s" is not a valid MediaId for Media entity.', $value),
                $e->getCode(),
                $e
            );
        }
    }
}
