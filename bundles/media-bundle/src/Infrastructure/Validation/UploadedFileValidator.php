<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Infrastructure\Validation;

use Zenchron\FileManagerBundle\Application\CreateMedia\UploadedFileRequest;
use Zenchron\FileManagerBundle\Domain\Exception\UploadFileException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UploadedFileValidator
{


    /**
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     * @param string[] $mimeTypes
     * @param int $maxFileSize
     */
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly array $mimeTypes,
        private readonly int $maxFileSize
    ) {
    }

    public function validate(UploadedFileRequest $uploadedFileRequest): void
    {
        $constraints = [
            'path'      => new Assert\NotBlank(),
            'name'      => new Assert\NotBlank(),
            'extension' => new Assert\NotBlank(),
            'mime'      => new MimeTypeConstraint($this->mimeTypes, $uploadedFileRequest->extension()),
            'size'      => [
                new Assert\LessThanOrEqual($this->maxFileSize),
            ],
        ];

        $constraintViolationList = $this->validator->validate(
            [
            'path'      => $uploadedFileRequest->path(),
            'name'      => $uploadedFileRequest->name(),
            'extension' => $uploadedFileRequest->extension(),
            'mime'      => $uploadedFileRequest->mime(),
            'size'      => $uploadedFileRequest->size(),
        ],
            new Assert\Collection($constraints)
        );

        if (count($constraintViolationList) > 0) {
            $errors = [];
            foreach ($constraintViolationList as $violation) {
                $errors[] = $violation->getPropertyPath().': '.$violation->getMessage();
            }
            throw new UploadFileException(\implode(', ', $errors));
        }
    }
}
