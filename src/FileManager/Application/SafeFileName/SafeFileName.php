<?php
declare(strict_types=1);

namespace App\FileManager\Application\SafeFileName;

use App\FileManager\Domain\Contract\MediaRepositoryInterface;
use App\FileManager\Domain\Exception\NotFoundMediaException;
use App\Shared\Common\FileHelper;

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
