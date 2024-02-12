<?php

namespace App\Repository;

use App\Entity\Pump;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pump>
 *
 * @method Pump|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pump|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pump[]    findAll()
 * @method Pump[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PumpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pump::class);
    }

//    /**
//     * @return Pump[] Returns an array of Pump objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Pump
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
