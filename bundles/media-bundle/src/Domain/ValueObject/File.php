<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\ValueObject;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Zenchron\SharedBundle\Domain\ValueObject\MappingTrait;

#[ORM\Embeddable]
final class File
{
    use MappingTrait;

    #[ORM\Column(type: Types::STRING, length: 200)]
    private readonly string $name;

    #[ORM\Column(type: Types::STRING, length: 300)]
    private readonly string $path;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private readonly string $mime;

    #[ORM\Column(type: Types::STRING, length: 6)]
    private readonly string $extension;

    /**
     * The filesize in bytes
     */
    #[ORM\Column(type: Types::INTEGER)]
    private readonly int $size;

    /**
     * Null by default is required for doctrine
     * @var string|null
     */
    private ?string $baseName = null;

    public function __construct(string $name, string $path, string $mime, string $extension, int $size)
    {
        $this->name      = $name;
        $this->path      = $path;
        $this->mime      = $mime;
        $this->extension = $extension;
        $this->size      = $size;
        $this->baseName  = $this->basenameFromName();
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromRequest(array $data): self
    {
        $file = new self(
            self::getString($data, 'name'),
            self::getString($data, 'path'),
            self::getString($data, 'mime'),
            self::getString($data, 'extension'),
            self::getInt($data, 'size')
        );

        $file->baseName = $file->baseName();

        return $file;
    }


    public function name(): string
    {
        return $this->name;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function mime(): string
    {
        return $this->mime;
    }

    public function extension(): string
    {
        return $this->extension;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function baseName(): string
    {
        if (!$this->baseName) {
            $this->baseName = $this->basenameFromName();
        }

        return $this->baseName;
    }

    public function update(string $name, string $path): self
    {
        return new self(
            $name,
            $path,
            $this->mime,
            $this->extension,
            $this->size
        );
    }

    public function updateSize(int $size): self
    {
        return new self(
            $this->name,
            $this->path,
            $this->mime,
            $this->extension,
            $size
        );
    }

    private function basenameFromName(): string
    {
        return \pathinfo($this->name, \PATHINFO_FILENAME);
    }

}
