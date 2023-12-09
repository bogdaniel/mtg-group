<?php
declare(strict_types=1);

namespace Zenchron\SharedBundle\Application\Dto;


interface ResponseDtoInterface extends \JsonSerializable
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
