<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function create(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function read(int $id): ?User
    {
        return $this->find($id);
    }

    public function update(User $user): void
    {
        $this->_em->flush();
    }

    public function delete(User $user): void
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }
}
