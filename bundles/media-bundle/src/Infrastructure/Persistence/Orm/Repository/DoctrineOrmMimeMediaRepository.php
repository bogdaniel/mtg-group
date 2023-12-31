<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Infrastructure\Persistence\Orm\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Zenchron\FileManagerBundle\Domain\Contract\MimeMediaRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\Model\Media;

/**
 * @extends ServiceEntityRepository<Media>
 */
final class DoctrineOrmMimeMediaRepository extends ServiceEntityRepository implements MimeMediaRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }


    public function getAll(): array
    {
        return $this
            ->createQueryBuilder('m')
            ->select('m.file.mime as mime', 'count(m) as count')
            ->groupBy('m.file.mime')
            ->getQuery()
            ->getResult();
    }

    public function getAllByType(): array
    {
       return $this
            ->createQueryBuilder('m')
            ->select('MIME_TYPE(m.file.mime) as mimeType', 'count(m) as count')
            ->groupBy('mimeType')
            ->getQuery()->getResult();

    }

    public function getAllBySubType(): array
    {
        return $this
            ->createQueryBuilder('m')
            ->select('MIME_SUBTYPE(m.file.mime) as mimeSubType', 'count(m) as count')
            ->groupBy('mimeSubType')
            ->getQuery()
            ->getResult();
    }

}
