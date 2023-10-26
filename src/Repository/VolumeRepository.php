<?php

namespace App\Repository;

use App\Entity\Contract\VolumeEntityContract;
use App\Entity\VolumeEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VolumeEntityContract|null find($id, $lockMode = null, $lockVersion = null)
 * @method VolumeEntityContract|null findOneBy(array $criteria, array $orderBy = null)
 * @method VolumeEntityContract[]    findAll()
 * @method VolumeEntityContract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VolumeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VolumeEntity::class);
    }

    public function create(VolumeEntityContract $volume): void
    {
        $this->_em->persist($volume);
        $this->_em->flush();
    }

    public function read(int $id): ?VolumeEntityContract
    {
        return $this->find($id);
    }

    public function update(VolumeEntityContract $volume): void
    {
        $this->_em->flush();
    }

    public function delete(VolumeEntityContract $volume): void
    {
        $this->_em->remove($volume);
        $this->_em->flush();
    }
}
