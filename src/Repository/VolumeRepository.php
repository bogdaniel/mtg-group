<?php

namespace App\Repository;

use App\Entity\Volume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VolumeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Volume::class);
    }

    public function create(Volume $volume): void
    {
        $this->_em->persist($volume);
        $this->_em->flush();
    }

    public function read(int $id): ?Volume
    {
        return $this->find($id);
    }

    public function update(Volume $volume): void
    {
        $this->_em->flush();
    }

    public function delete(Volume $volume): void
    {
        $this->_em->remove($volume);
        $this->_em->flush();
    }
}
