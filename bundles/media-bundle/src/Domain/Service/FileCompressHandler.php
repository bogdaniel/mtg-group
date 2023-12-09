<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\Service;

use Zenchron\FileManagerBundle\Domain\Contract\FileCompressInterface;
use Zenchron\FileManagerBundle\Domain\ValueObject\File;

class FileCompressHandler
{
    /**
     * @var array<FileCompressInterface>
     */
    private readonly array $handlers;

    /**
     * @param iterable<FileCompressInterface> $handlers
     */
    public function __construct(iterable $handlers)
    {
        $this->handlers = $handlers instanceof \Traversable ? \iterator_to_array($handlers) : $handlers;
    }

    public function compress(string $absolutePath, File $file): bool
    {

        foreach ($this->handlers as $handler) {
            if ($handler instanceof FileCompressInterface && $handler->support($file)) {
                $handler->compress($absolutePath);
                return true;
            }
        }

        return false;
    }

    public function support(File $file): bool
    {
        foreach ($this->handlers as $handler) {
            if ($handler instanceof FileCompressInterface && $handler->support($file)) {
                return true;
            }
        }
        return false;
    }
}
