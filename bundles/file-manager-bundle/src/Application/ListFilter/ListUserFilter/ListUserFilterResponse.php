<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\ListFilter\ListUserFilter;

use Zenchron\SharedBundle\Application\Dto\ResponseFormFilterDtoInterface;
use Zenchron\SharedBundle\Domain\ValueObject\MappingTrait;
use Zenchron\SharedBundle\Domain\ValueObject\UserIdentifier;

class ListUserFilterResponse implements ResponseFormFilterDtoInterface
{
    use MappingTrait;


    private function __construct(
        private readonly string $username,
        private readonly int $count
    ) {
    }


    public function value(): string
    {
        return $this->username;
    }


    public function label(): string
    {
        return \sprintf('%s (%d)', $this->username, $this->count);
    }


    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        if (!isset($data['username'])) {
            throw new \InvalidArgumentException('Missing username into the '.self::class.' class');
        }
        if ($data['username'] instanceof UserIdentifier){
            $data['username'] = $data['username']->value();
        }
        return new self(
            self::getString($data, 'username'),
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
