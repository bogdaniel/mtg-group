<?php

namespace App\Repository;

use App\Entity\FileEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileEntity::class);
    }

    public function create(FileEntity $file): void
    {
        $this->_em->persist($file);
        $this->_em->flush();
    }

    public function read(int $id): ?FileEntity
    {
        return $this->find($id);
    }

    public function update(FileEntity $file): void
    {
        $this->_em->flush();
    }

    public function delete(FileEntity $file): void
    {
        $this->_em->remove($file);
        $this->_em->flush();
    }
}
