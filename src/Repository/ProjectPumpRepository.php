<?php

namespace App\Repository;

use App\Entity\ProjectPump;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectPump>
 *
 * @method ProjectPump|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectPump|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectPump[]    findAll()
 * @method ProjectPump[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectPumpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectPump::class);
    }

//    /**
//     * @return ProjectPump[] Returns an array of ProjectPump objects
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

//    public function findOneBySomeField($value): ?ProjectPump
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function save(ProjectPump $projectPump): ProjectPump
    {
        $this->_em->persist($projectPump);
        $this->_em->flush();

        return $projectPump;
    }
}
