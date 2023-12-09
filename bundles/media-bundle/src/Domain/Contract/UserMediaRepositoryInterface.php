<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\Contract;


use Zenchron\SharedBundle\Domain\ValueObject\UserIdentifier;

interface UserMediaRepositoryInterface
{

    /**
     * @return \Symfony\Component\Security\Core\User\UserInterface[]
     */
    public function getAll(): array;

    public function getUsernameByUserIdentifier(UserIdentifier $userIdentifier): string;
}
