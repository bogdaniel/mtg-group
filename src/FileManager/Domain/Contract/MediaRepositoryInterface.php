<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Contract;


use App\FileManager\Domain\Model\Media;
use App\FileManager\Domain\ValueObject\MediaId;
use App\Shared\Filter\Criteria;
use App\Shared\Filter\Order\OrderBy;
use App\Shared\Filter\Pagination\OffsetPagination;

interface MediaRepositoryInterface
{


    public function nextIdentity(): MediaId;

    /**
     * @return Media[]
     */
    public function getAll(OrderBy $orderPagination): array;

    public function size(?Criteria $criteria = null): int;

    /**
     * @param \App\Shared\Filter\Criteria $criteria
     * @return Media[]
     */
    public function filter(Criteria $criteria): array;

    /**
     * @param \App\Shared\Filter\Pagination\OffsetPagination $offsetPagination
     * @param \App\Shared\Filter\Order\OrderBy $orderPagination
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
