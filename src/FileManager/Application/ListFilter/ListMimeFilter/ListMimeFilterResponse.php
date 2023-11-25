<?php
declare(strict_types=1);

namespace App\FileManager\Application\ListFilter\ListMimeFilter;

use App\Shared\Application\Dto\ResponseFormFilterDtoInterface;
use App\Shared\Domain\ValueObject\MappingTrait;

class ListMimeFilterResponse implements ResponseFormFilterDtoInterface
{

    use MappingTrait;

    private function __construct(private readonly string $mimeType, private readonly int $count)
    {
    }


    public function value(): string
    {
        return $this->mimeType;
    }

    public function label(): string
    {
        return \sprintf('%s (%d)', $this->mimeType, $this->count);
    }

    /**
     * @param array<string,mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            self::getString($data, 'mimeType'),
            self::getInt($data, 'count')
        );
    }

    /**
     * @return array<string,string>
     */
    public function toArray(): array
    {
        return [
            'label' => $this->label(),
            'value' => $this->value(),
        ];
    }

    /**
     * @return array<string,string>
     */
    public function jsonSerialize(): array
    {
       return $this->toArray();
    }
}
