<?php

namespace App\Repository;

use App\Entity\Metadata;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MetadataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Metadata::class);
    }

    public function create(Metadata $metadata): void
    {
        $this->_em->persist($metadata);
        $this->_em->flush();
    }

    public function read(int $id): ?Metadata
    {
        return $this->find($id);
    }

    public function update(Metadata $metadata): void
    {
        $this->_em->flush();
    }

    public function delete(Metadata $metadata): void
    {
        $this->_em->remove($metadata);
        $this->_em->flush();
    }
}
