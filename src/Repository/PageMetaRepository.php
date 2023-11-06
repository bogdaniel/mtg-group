<?php

namespace App\Repository;

use App\Entity\PageMeta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PageMeta>
 *
 * @method PageMeta|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageMeta|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageMeta[]    findAll()
 * @method PageMeta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageMetaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageMeta::class);
    }

    public function save(PageMeta $pageMeta): void
    {
        $this->_em->persist($pageMeta);
        $this->_em->flush();
    }

    public function delete(PageMeta $pageMeta): void
    {
        $this->_em->remove($pageMeta);
        $this->_em->flush();
    }

//    /**
//     * @return PageMeta[] Returns an array of PageMeta objects
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

//    public function findOneBySomeField($value): ?PageMeta
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
