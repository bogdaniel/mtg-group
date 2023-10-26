<?php

namespace App\Repository;

use App\Entity\VolumeEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VolumeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VolumeEntity::class);
    }

    public function create(VolumeEntity $volume): void
    {
        $this->_em->persist($volume);
        $this->_em->flush();
    }

    public function read(int $id): ?VolumeEntity
    {
        return $this->find($id);
    }

    public function update(VolumeEntity $volume): void
    {
        $this->_em->flush();
    }

    public function delete(VolumeEntity $volume): void
    {
        $this->_em->remove($volume);
        $this->_em->flush();
    }
}
