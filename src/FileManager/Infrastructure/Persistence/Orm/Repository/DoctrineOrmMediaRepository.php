<?php

declare(strict_types=1);

namespace App\FileManager\Infrastructure\Persistence\Orm\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use App\FileManager\Domain\Contract\MediaRepositoryInterface;
use App\FileManager\Domain\Criteria\MediaCriteria;
use App\FileManager\Domain\Exception\NotFoundMediaException;
use App\FileManager\Domain\Model\Media;
use App\FileManager\Domain\ValueObject\MediaId;
use App\Shared\Filter\Criteria;
use App\Shared\Filter\CriteriaBuilder\DoctrineCriteriaBuilderFactory;
use App\Shared\Filter\Order\OrderBy;
use App\Shared\Filter\Pagination\OffsetPagination;
use App\Shared\Infrastructure\Persistence\Orm\UidMapperPlatform;

/**
 * @extends ServiceEntityRepository<Media>
 */
final class DoctrineOrmMediaRepository extends ServiceEntityRepository implements MediaRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly DoctrineCriteriaBuilderFactory $doctrineCriteriaBuilderFactory,
        private readonly UidMapperPlatform $uidMapperPlatform,
    ) {
        parent::__construct($registry, Media::class);
    }

    public function nextIdentity(): MediaId
    {
        return MediaId::create();
    }

    public function filter(Criteria $criteria): array
    {
        $queryBuilder = $this->createQueryBuilder($criteria::modelAlias());

        return $this->doctrineCriteriaBuilderFactory
            ->create($queryBuilder, $criteria)
            ->where()
            ->withLimit()
            ->withOrder()
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function size(?Criteria $criteria = null): int
    {
        if (!$criteria) {
            return $this->count([]);
        }

        $queryBuilder = $this
            ->createQueryBuilder($criteria::modelAlias())
            ->select('COUNT('.$criteria::modelAlias().'.id)');

        return $this->doctrineCriteriaBuilderFactory
            ->create($queryBuilder, $criteria)
            ->where()
            ->getQuery()
            ->getSingleScalarResult();
    }


    public function getByFileName(string $fileName): Media
    {
        $media = $this->findOneBy(['file.name' => $fileName]);
        if (!$media) {
            throw NotFoundMediaException::withFileName($fileName);
        }

        return $media;
    }

    /**
     * @return Media[]
     */
    public function findByFileNames(array $fileNames): array
    {
        return $this->findBy(['file.name' => $fileNames]);
    }

    public function getById(MediaId $id): Media
    {
        $media = $this->find($id);
        if (null === $media) {
            throw NotFoundMediaException::withId((string)$id);
        }

        return $media;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @return Media[]
     */
    public function findByIds(MediaId ...$ids): array
    {
        $mediaIds        = \array_map( fn(MediaId $mediaId) => $this->uidMapperPlatform->convertToDatabaseValue(
            $mediaId
        ), $ids);
        $criteria        = MediaCriteria::default();
        $orderPagination = $criteria->orderBy();

        return $this
            ->createQueryBuilder('m')
            ->where('m.id IN (:ids)')
            ->setParameter('ids', $mediaIds)
            ->orderBy($orderPagination->field(), $orderPagination->direction())
            ->getQuery()
            ->getResult();
    }

    public function getAll(OrderBy $orderPagination): array
    {
        return $this->getAllQueryBuilder($orderPagination)->getQuery()->getResult();
    }

    public function paginate(OffsetPagination $offsetPagination, OrderBy $orderPagination): array
    {
        return $this
            ->getAllQueryBuilder($orderPagination)
            ->setFirstResult(($offsetPagination->page() - 1) * $offsetPagination->limit())
            ->setMaxResults($offsetPagination->limit())
            ->getQuery()
            ->getResult();
    }

    private function getAllQueryBuilder(OrderBy $orderPagination): QueryBuilder
    {
        return $this
            ->createQueryBuilder('m')
            ->orderBy('m.'.$orderPagination->field(), $orderPagination->direction());
    }

    public function save(Media $media): void
    {
        $this->getEntityManager()->persist($media);
        $this->getEntityManager()->flush();
    }

    public function delete(Media $media): void
    {
        $this->getEntityManager()->remove($media);
        $this->getEntityManager()->flush();
    }
}
