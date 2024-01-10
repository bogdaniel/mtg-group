<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Infrastructure\Persistence\Orm\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Zenchron\FileBundle\Domain\Contract\AvailableDatesMediaRepository;
use Zenchron\FileBundle\Domain\Model\Media;

/**
 * @extends ServiceEntityRepository<Media>
 */
final class DoctrineOrmAvailableDatesMediaRepository extends ServiceEntityRepository implements
    AvailableDatesMediaRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }


    /**
     * @return array|\Ranky\FileBundle\Domain\Model\Media[]
     */
    public function getAll(): array
    {
        return $this
            ->createQueryBuilder('m')
            ->select('YEAR(m.createdAt) as year', 'MONTH(m.createdAt) as month', 'count(m) as count')
            ->groupBy('year', 'month')
            ->orderBy('m.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
