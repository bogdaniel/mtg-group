<?php

declare(strict_types=1);

namespace Zenchron\FileBundle\Domain\Service;

use Zenchron\FileBundle\Domain\Contract\GenerateThumbnails;
use Zenchron\FileBundle\Domain\ValueObject\Dimension;
use Zenchron\FileBundle\Domain\ValueObject\File;
use Zenchron\SharedBundle\Domain\Service\ValidateHandlersTrait;

class GenerateThumbnailsHandler
{
    use ValidateHandlersTrait;

    /**
     * @var array<GenerateThumbnails>
     */
    private readonly array $handlers;

    /**
     * @param iterable<GenerateThumbnails> $handlers
     * @throws \Exception
     */
    public function __construct(iterable $handlers)
    {
        $this->handlers = $this->validateHandlers($handlers, GenerateThumbnails::class);
    }

    public function generate(string $mediaId, File $file, Dimension $dimension): bool
    {
        foreach ($this->handlers as $handler) {
            if ($handler->support($file)) {
                $handler->generate($mediaId, $file, $dimension);

                return true;
            }
        }

        return false;
    }

    public function support(File $file): bool
    {
        foreach ($this->handlers as $handler) {
            if ($handler->support($file)) {
                return true;
            }
        }

        return false;
    }
}
