<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\Contract;


use Zenchron\FileManagerBundle\Domain\Model\Media;
use Zenchron\FileManagerBundle\Domain\ValueObject\MediaId;
use Zenchron\SharedBundle\Filter\Criteria;
use Zenchron\SharedBundle\Filter\Order\OrderBy;
use Zenchron\SharedBundle\Filter\Pagination\OffsetPagination;

interface MediaRepositoryInterface
{


    public function nextIdentity(): MediaId;

    /**
     * @return Media[]
     */
    public function getAll(OrderBy $orderPagination): array;

    public function size(?Criteria $criteria = null): int;

    /**
     * @param \Zenchron\SharedBundle\Filter\Criteria $criteria
     * @return Media[]
     */
    public function filter(Criteria $criteria): array;

    /**
     * @param \Zenchron\SharedBundle\Filter\Pagination\OffsetPagination $offsetPagination
     * @param \Zenchron\SharedBundle\Filter\Order\OrderBy $orderPagination
     * @return Media[]
     */
    public function paginate(OffsetPagination $offsetPagination, OrderBy $orderPagination): array;

    public function getById(MediaId $id): Media;

    public function getByFileName(string $fileName): Media;

    /**
     * @param MediaId ...$ids
     * @return Media[]
     */
    public function findByIds(MediaId ...$ids): array;

    /**
     * @param string[] $fileNames
     * @return Media[]
     */
    public function findByFileNames(array $fileNames): array;

    public function save(Media $media): void;

    public function delete(Media $media): void;
}
