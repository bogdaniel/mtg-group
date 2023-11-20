<?php
declare(strict_types=1);

namespace App\Shared\Application\Contract;


interface ResponseDataTransferObjectContract extends \JsonSerializable
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
