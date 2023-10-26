<?php

namespace App\Repository;

use App\Entity\File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }

    public function create(File $file): void
    {
        $this->_em->persist($file);
        $this->_em->flush();
    }

    public function read(int $id): ?File
    {
        return $this->find($id);
    }

    public function update(File $file): void
    {
        $this->_em->flush();
    }

    public function delete(File $file): void
    {
        $this->_em->remove($file);
        $this->_em->flush();
    }
}
