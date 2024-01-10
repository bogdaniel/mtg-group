<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Domain\Service;

use Zenchron\FileBundle\Domain\Contract\FileResize;
use Zenchron\FileBundle\Domain\ValueObject\Dimension;
use Zenchron\FileBundle\Domain\ValueObject\File;
use Zenchron\SharedBundle\Domain\Service\ValidateHandlersTrait;
class FileResizeHandler
{
    use ValidateHandlersTrait;

    /** @var array<FileResize> */
    private readonly array $handlers;

    /**
     * @param iterable<FileResize> $handlers
     * @throws \Exception
     */
    public function __construct(iterable $handlers)
    {
        $this->handlers = $this->validateHandlers($handlers, FileResize::class);
    }

    public function resize(File $file, string $inputPath, string $outputPath, Dimension $dimension): bool
    {
        foreach ($this->handlers as $handler) {
            if ($handler->support($file)) {
                return $handler->resize($inputPath, $outputPath, $dimension);
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
