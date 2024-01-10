<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Domain\Service;

use Zenchron\FileBundle\Domain\Contract\FileCompress;
use Zenchron\FileBundle\Domain\ValueObject\File;
use Zenchron\SharedBundle\Domain\Service\ValidateHandlersTrait;

class FileCompressHandler
{
    use ValidateHandlersTrait;

     /** @var array<FileCompress> */
    private readonly array $handlers;

    /**
     * @param iterable<FileCompress> $handlers
     * @throws \Exception
     */
    public function __construct(iterable $handlers)
    {
        $this->handlers = $this->validateHandlers($handlers, FileCompress::class);
    }

    public function compress(File $file, string $path): bool
    {
        foreach ($this->handlers as $handler) {
            if ($handler->support($file)) {
                $handler->compress($path);
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
