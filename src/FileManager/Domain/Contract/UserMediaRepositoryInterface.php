<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Contract;


use App\Shared\Domain\ValueObject\UserIdentifier;

interface UserMediaRepositoryInterface
{

    /**
     * @return \Symfony\Component\Security\Core\User\UserInterface[]
     */
    public function getAll(): array;

    public function getUsernameByUserIdentifier(UserIdentifier $userIdentifier): string;
}
