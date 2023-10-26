<?php

namespace App\Repository;

use App\Entity\Operator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OperatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operator::class);
    }

    public function create(Operator $operator): void
    {
        $this->_em->persist($operator);
        $this->_em->flush();
    }

    public function read(int $id): ?Operator
    {
        return $this->find($id);
    }

    public function update(Operator $operator): void
    {
        $this->_em->flush();
    }

    public function delete(Operator $operator): void
    {
        $this->_em->remove($operator);
        $this->_em->flush();
    }
}
