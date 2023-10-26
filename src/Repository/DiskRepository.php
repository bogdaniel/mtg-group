<?php

namespace App\Repository;

use App\Domain\Contract\DiskConfigurationDataContract;
use App\Entity\Disk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DiskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Disk::class);
    }

    public function create(DiskConfigurationDataContract $disk): void
    {
        $this->_em->persist($disk);
        $this->_em->flush();
    }

    public function read(int $id): ?Disk
    {
        return $this->find($id);
    }

    public function update(DiskConfigurationDataContract $disk): void
    {
        $this->_em->flush();
    }

    public function delete(DiskConfigurationDataContract $disk): void
    {
        $this->_em->remove($disk);
        $this->_em->flush();
    }
}
