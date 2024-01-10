<?php

declare(strict_types=1);

namespace Zenchron\FileBundle\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Zenchron\FileBundle\Domain\Event\MediaCreated;
use Zenchron\FileBundle\Domain\Event\MediaDeleted;
use Zenchron\FileBundle\Domain\Event\MediaDescriptionChanged;
use Zenchron\FileBundle\Domain\Event\MediaDimensionChanged;
use Zenchron\FileBundle\Domain\Event\MediaFileSizeChanged;
use Zenchron\FileBundle\Domain\Event\MediaFileChanged;
use Zenchron\FileBundle\Domain\Event\MediaThumbnailsAdded;
use Zenchron\FileBundle\Domain\Event\MediaThumbnailsChanged;
use Zenchron\FileBundle\Domain\ValueObject\Description;
use Zenchron\FileBundle\Domain\ValueObject\Dimension;
use Zenchron\FileBundle\Domain\ValueObject\File;
use Zenchron\FileBundle\Domain\ValueObject\MediaId;
use Zenchron\FileBundle\Domain\ValueObject\Thumbnails;
use Zenchron\SharedBundle\Domain\AggregateRoot;
use Zenchron\SharedBundle\Domain\Traits\DateAtTrait;
use Zenchron\SharedBundle\Domain\ValueObject\UserIdentifier;

#[ORM\Entity]
#[ORM\Table(name: 'zenchron_file')]
#[ORM\Index(columns: ['id', 'name', 'extension', 'mime', 'created_by'], name: 'search_idx')]
class Media extends AggregateRoot
{
    public const IMAGE_QUALITY            = 80;
    public const ORIGINAL_IMAGE_MAX_WIDTH = 1920;
    public const MAX_FILE_SIZE            = 7340032;

    use DateAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'media_id', unique: true)]
    private MediaId $id;


    #[ORM\Embedded(class: File::class, columnPrefix: false)]
    private File $file;

    #[ORM\Embedded(class: Dimension::class, columnPrefix: false)]
    private Dimension $dimension;


    #[ORM\Embedded(class: Description::class, columnPrefix: false)]
    private Description $description;


    #[ORM\Column(type: 'thumbnail_collection')]
    private Thumbnails $thumbnails;


    #[ORM\Column(name: 'created_by', type: 'user_identifier', nullable: false)]
    private UserIdentifier $createdBy;


    #[ORM\Column(name: 'updated_by', type: 'user_identifier', nullable: false)]
    private UserIdentifier $updatedBy;


    private function __construct(
        MediaId $id,
        File $file,
        UserIdentifier $userIdentifier,
        Dimension $dimension,
        Description $description
    ) {
        $this->id          = $id;
        $this->file        = $file;
        $this->dimension   = $dimension;
        $this->description = $description;
        $this->thumbnails  = new Thumbnails();
        $this->createdBy   = $userIdentifier;
        $this->updatedBy   = $userIdentifier;
    }

    public static function create(
        MediaId $id,
        File $file,
        UserIdentifier $userIdentifier,
        Dimension $dimension,
        Description $description
    ): self {
        $media            = new self($id, $file, $userIdentifier, $dimension, $description);
        $now              = new \DateTimeImmutable();
        $media->createdAt = $now;
        $media->updatedAt = $now;
        $media->record(new MediaCreated((string)$id));

        return $media;
    }

    public function delete(): void
    {
        $this->record(
            new MediaDeleted(
                $this->id->asString(),
                [
                    'name' => $this->file->name(),
                    'thumbnails' => $this->thumbnails->toArray(),
                ]
            )
        );
    }

    public function changeDescription(Description $description, UserIdentifier $userIdentifier): void
    {
        $this->description = $description;
        $this->updatedAt   = new \DateTimeImmutable();
        $this->updatedBy   = $userIdentifier;

        $this->record(
            new MediaDescriptionChanged(
                $this->id->asString(),
                ['description' => $description->toArray()]
            )
        );
    }

    public function changeFile(File $file, UserIdentifier $userIdentifier): void
    {
        $this->file      = $file;
        $this->updatedAt = new \DateTimeImmutable();
        $this->updatedBy = $userIdentifier;

        $this->record(
            new MediaFileChanged(
                $this->id()->asString(),
                [
                    'name' => $file->name(),
                ]
            )
        );
    }

    public function changeDimension(Dimension $dimension): void
    {
        $this->dimension = $dimension;
        $this->record(
            new MediaDimensionChanged(
                $this->id->asString(),
                [
                    'dimension' => $dimension->toArray(),
                ]
            )
        );
    }

    public function changeFileSize(int $size): void
    {
        $this->file = $this->file->changeSize($size);

        $this->record(
            new MediaFileSizeChanged(
                $this->id->asString(),
                [
                    'size' => $size,
                ]
            )
        );
    }

    public function addThumbnails(Thumbnails $thumbnails): void
    {
        $this->thumbnails = $thumbnails;

        $this->record(
            new MediaThumbnailsAdded(
                $this->id->asString(),
                [
                    'name' => $this->file->name(),
                    'thumbnails' => $this->thumbnails->toArray(),
                ]
            )
        );
    }

    public function changeThumbnails(Thumbnails $thumbnails): void
    {
        $this->thumbnails = $thumbnails;

        $this->record(
            new MediaThumbnailsChanged(
                $this->id->asString(),
                [
                    'name' => $this->file->name(),
                    'thumbnails' => $this->thumbnails->toArray(),
                ]
            )
        );
    }

    public function id(): MediaId
    {
        return $this->id;
    }

    public function file(): File
    {
        return $this->file;
    }

    public function dimension(): Dimension
    {
        return $this->dimension;
    }

    public function description(): Description
    {
        return $this->description;
    }

    public function thumbnails(): Thumbnails
    {
        return $this->thumbnails;
    }

    public function createdBy(): UserIdentifier
    {
        return $this->createdBy;
    }

    public function updatedBy(): UserIdentifier
    {
        return $this->updatedBy;
    }
}