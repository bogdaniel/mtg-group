<?php

namespace App\Repository;

use App\Entity\Contract\FileEntityContract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FileEntityContract|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileEntityContract|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileEntityContract[]    findAll()
 * @method FileEntityContract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileEntityContract::class);
    }

    public function create(FileEntityContract $file): void
    {
        $this->_em->persist($file);
        $this->_em->flush();
    }

    public function read(int $id): ?FileEntityContract
    {
        return $this->find($id);
    }

    public function update(FileEntityContract $file): void
    {
        $this->_em->flush();
    }

    public function delete(FileEntityContract $file): void
    {
        $this->_em->remove($file);
        $this->_em->flush();
    }
}
