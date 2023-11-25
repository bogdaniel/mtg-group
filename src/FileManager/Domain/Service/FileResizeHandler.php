<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Service;

use App\FileManager\Domain\Contract\FileResizeInterface;
use App\FileManager\Domain\ValueObject\Dimension;
use App\FileManager\Domain\ValueObject\File;

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
