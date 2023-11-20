<?php
declare(strict_types=1);

namespace App\Shared\Application\Contract;

interface RequestDataTransferObjectContract extends \JsonSerializable
{
    public const DEFAULT_VALIDATION_GROUP = ['Default'];

    /**
     * @param array<string,string> $data
     * @return self
     */
    public static function fromRequest(array $data): self;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
