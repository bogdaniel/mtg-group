<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\SafeFileName;

use Zenchron\FileManagerBundle\Domain\Contract\MediaRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\Exception\NotFoundMediaException;
use Zenchron\SharedBundle\Common\FileHelper;

class SafeFileName
{

    public function __construct(private readonly MediaRepositoryInterface $mediaRepository)
    {
    }

    public function __invoke(string $name, ?string $extension = null): string
    {
        if ($extension === null) {
            $extension = (string)\pathinfo($name, \PATHINFO_EXTENSION);
        }
        $formatName = FileHelper::basename($name);
        $fullName   = \sprintf('%s.%s', $formatName, $extension);
        try {
            $this->mediaRepository->getByFileName($fullName);
        } catch (NotFoundMediaException){
            return $fullName;
        }

        return \sprintf('%s-%d.%s', $formatName, \time(), $extension);
    }
}
