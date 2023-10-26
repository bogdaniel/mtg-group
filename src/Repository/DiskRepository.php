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
