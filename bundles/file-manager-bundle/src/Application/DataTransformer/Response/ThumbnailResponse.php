<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\DataTransformer\Response;

use Zenchron\FileBundle\Domain\ValueObject\Thumbnail;
use Zenchron\SharedBundle\Common\FileHelper;

final class ThumbnailResponse
{

    public function __construct(
        private readonly string $breakpoint,
        private readonly string $name,
        private readonly string $url,
        private readonly int $size,
        private readonly DimensionResponse $dimension = new DimensionResponse()
    ) {
    }

    public static function fromThumbnail(Thumbnail $thumbnail, string|callable $uploadUrl): self
    {
        if (!\is_callable($uploadUrl)) {
            $url =  \sprintf('%s/%s', $uploadUrl, \ltrim($thumbnail->path(), '/'));
        }else{
            $url = $uploadUrl($thumbnail->path());
        }


        return new self(
            $thumbnail->breakpoint(),
            $thumbnail->name(),
            $url,
            $thumbnail->size(),
            DimensionResponse::fromDimension($thumbnail->dimension())
        );
    }

    public function breakpoint(): string
    {
        return $this->breakpoint;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function dimension(): DimensionResponse
    {
        return $this->dimension;
    }

    public function humanSize(): string
    {
        return FileHelper::humanFileSize($this->size);
    }


}
