<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\Service;

use Zenchron\FileManagerBundle\Domain\Contract\FileResizeInterface;
use Zenchron\FileManagerBundle\Domain\ValueObject\Dimension;
use Zenchron\FileManagerBundle\Domain\ValueObject\File;

class FileResizeHandler
{
    /**
     * @var array<FileResizeInterface>
     */
    private readonly array $handlers;

    /**
     * @param iterable<FileResizeInterface> $handlers
     */
    public function __construct(iterable $handlers)
    {
        $this->handlers = $handlers instanceof \Traversable ? \iterator_to_array($handlers) : $handlers;
    }

    public function resize(File $file, string $inputPath, string $outputPath, Dimension $dimension): bool
    {

        foreach ($this->handlers as $handler) {
            if ($handler instanceof FileResizeInterface && $handler->support($file)) {
                return $handler->resize($inputPath, $outputPath, $dimension);
            }
        }

        return false;
    }

    public function support(File $file): bool
    {
        foreach ($this->handlers as $handler) {
            if ($handler instanceof FileResizeInterface && $handler->support($file)) {
                return true;
            }
        }
        return false;
    }
}
