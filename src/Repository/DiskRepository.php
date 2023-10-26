<?php

namespace App\Repository;

use App\Entity\Contract\DiskConfigurationEntityContract;
use App\Entity\Disk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DiskConfigurationEntityContract|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiskConfigurationEntityContract|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiskConfigurationEntityContract[]    findAll()
 * @method DiskConfigurationEntityContract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Disk::class);
    }

    public function create(DiskConfigurationEntityContract $disk): void
    {
        $this->_em->persist($disk);
        $this->_em->flush();
    }

    public function read(int $id): ?Disk
    {
        return $this->find($id);
    }

    public function update(DiskConfigurationEntityContract $disk): void
    {
        $this->_em->flush();
    }

    public function delete(DiskConfigurationEntityContract $disk): void
    {
        $this->_em->remove($disk);
        $this->_em->flush();
    }
}
