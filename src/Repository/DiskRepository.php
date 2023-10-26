<?php

namespace App\Repository;

use App\Entity\Disk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DiskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Disk::class);
    }

    public function create(Disk $disk): void
    {
        $this->_em->persist($disk);
        $this->_em->flush();
    }

    public function read(int $id): ?Disk
    {
        return $this->find($id);
    }

    public function update(Disk $disk): void
    {
        $this->_em->flush();
    }

    public function delete(Disk $disk): void
    {
        $this->_em->remove($disk);
        $this->_em->flush();
    }
}
<?php

namespace App\Repository;

use App\Entity\Disk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DiskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Disk::class);
    }

    // Add methods for creating, reading, updating, and deleting Disk records
}
