<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Model;


use Doctrine\ORM\Mapping as ORM;
use App\FileManager\Domain\Event\MediaCreated;
use App\FileManager\Domain\Event\MediaDeleted;
use App\FileManager\Domain\Event\MediaDescriptionUpdated;
use App\FileManager\Domain\Event\MediaDimensionUpdated;
use App\FileManager\Domain\Event\MediaFileSizeUpdated;
use App\FileManager\Domain\Event\MediaFileUpdated;
use App\FileManager\Domain\Event\MediaThumbnailsAdded;
use App\FileManager\Domain\Event\MediaThumbnailsUpdated;
use App\FileManager\Domain\ValueObject\Description;
use App\FileManager\Domain\ValueObject\Dimension;
use App\FileManager\Domain\ValueObject\File;
use App\FileManager\Domain\ValueObject\MediaId;
use App\FileManager\Domain\ValueObject\Thumbnails;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Traits\DateAtTrait;
use App\Shared\Domain\ValueObject\UserIdentifier;


#[ORM\Entity]
#[ORM\Table(name: 'ranky_media')]
#[ORM\Index(columns: ['id', 'name', 'extension', 'mime', 'created_by'], name: 'search_idx')]
class Media extends AggregateRoot
{
    public const IMAGE_QUALITY            = 80;
    public const ORIGINAL_IMAGE_MAX_WIDTH = 1920;
    public const MAX_FILE_SIZE            = 7340032;

    use DateAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'media_id')]
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
        $media->record(new MediaCreated((string)$id, ['name' => $file->name()]));

        return $media;
    }

    public function delete(): void
    {
        $this->record(
            new MediaDeleted(
                (string)$this->id,
                ['name' => $this->file->name(), 'thumbnails' => $this->thumbnails->toArray()]
            )
        );
    }

    public function updateDescription(Description $description, UserIdentifier $userIdentifier): void
    {
        $this->description = $description;
        $this->updatedAt   = new \DateTimeImmutable();
        $this->updatedBy   = $userIdentifier;

        $this->record(new MediaDescriptionUpdated((string)$this->id));
    }

    public function updateFile(File $file, UserIdentifier $userIdentifier): void
    {
        $this->file      = $file;
        $this->updatedAt = new \DateTimeImmutable();
        $this->updatedBy = $userIdentifier;

        $this->record(new MediaFileUpdated((string)$this->id(), ['name' => $file->name()]));
    }

    public function updateFileDimension(File $file, Dimension $dimension): void
    {
        $this->file      = $file;
        $this->dimension = $dimension;

        $this->record(new MediaFileUpdated((string)$this->id, ['name' => $file->name()]));
        $this->record(new MediaDimensionUpdated((string)$this->id, ['dimension' => $dimension->toArray()]));
    }

    public function updateFileSize(int $size): void
    {
        $oldSize    = $this->file->size();
        $this->file = $this->file->updateSize($size);

        $this->record(new MediaFileSizeUpdated((string)$this->id, ['oldSize' => $oldSize, 'newSize' => $size]));
    }

    public function addThumbnails(Thumbnails $thumbnails): void
    {
        $this->thumbnails = $thumbnails;

        $this->record(
            new MediaThumbnailsAdded(
                (string)$this->id,
                ['name' => $this->file->name(), 'thumbnails' => $this->thumbnails->toArray()]
            )
        );
    }

    public function updateThumbnails(Thumbnails $thumbnails): void
    {
        $this->thumbnails = $thumbnails;

        $this->record(
            new MediaThumbnailsUpdated(
                (string)$this->id,
                ['name' => $this->file->name(), 'thumbnails' => $this->thumbnails->toArray()]
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
