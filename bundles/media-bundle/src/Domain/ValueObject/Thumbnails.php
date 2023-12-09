<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\ValueObject;

use Zenchron\SharedBundle\Domain\ValueObject\Collection;

/** @extends Collection<Thumbnail> */
final class Thumbnails extends Collection
{

    protected function type(): string
    {
        return Thumbnail::class;
    }


    /**
     * @return array<int|string, array<string, mixed>>
     */
    public function toArray(): array
    {
        $array = [];
        foreach ($this->getIterator() as $key => $item) {
            /* @var $item Thumbnail */
            $array[$key] = [
                'breakpoint' => $item->breakpoint(),
                'name'       => $item->name(),
                'path'       => $item->path(),
                'size'       => $item->size(),
                'width'      => $item->dimension()->width(),
                'height'     => $item->dimension()->height(),
            ];
        }
        return $array;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $items = [];
        foreach ($data as $item) {
            $items[] = new Thumbnail(
                $item['breakpoint'],
                $item['name'],
                $item['path'],
                (int)$item['size'],
                new Dimension($item['width'] ?? null, $item['height'] ?? null)
            );
        }

        return new self($items);
    }

}
