<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zenchron\FileBundle\Application\FileManipulation\GenerateThumbnails\AbstractGenerateImageThumbnails;
use Zenchron\FileBundle\Application\FileManipulation\GenerateThumbnails\GenerateGifImageThumbnails;
use Zenchron\FileBundle\Application\FileManipulation\GenerateThumbnails\GenerateImageThumbnails;
use Zenchron\FileBundle\Domain\Contract\AvailableDatesMediaRepository;
use Zenchron\FileBundle\Domain\Contract\MimeMediaRepository;
use Zenchron\FileBundle\Domain\Service\FileCompressHandler;
use Zenchron\FileBundle\Domain\Service\FileResizeHandler;
use Zenchron\FileBundle\Domain\Service\GenerateThumbnailsHandler;
use Zenchron\FileBundle\Infrastructure\DependencyInjection\FileBundleExtension;
use Zenchron\FileBundle\Infrastructure\FileManipulation\Compression\SpatieFileCompression;
use Zenchron\FileBundle\Infrastructure\FileManipulation\Resize\FfmpegGifFileResize;
use Zenchron\FileBundle\Infrastructure\FileManipulation\Resize\GifsicleGifFileResize;
use Zenchron\FileBundle\Infrastructure\FileManipulation\Resize\ImagickGifFileResize;
use Zenchron\FileBundle\Infrastructure\FileManipulation\Resize\InterventionFileResize;
use Zenchron\FileBundle\Infrastructure\Persistence\Orm\Repository\DoctrineOrmAvailableDatesMediaRepository;
use Zenchron\FileBundle\Infrastructure\Persistence\Orm\Repository\DoctrineOrmMimeMediaRepository;
use Zenchron\FileBundle\Infrastructure\Validation\UploadedFileValidator;

return static function (ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc
        ->autowire(); // Automatically injects dependencies in your services


    $services
        ->load('Zenchron\\FileBundle\\', '../src/*')
        ->exclude([
            '../src/{DependencyInjection,DQL,Contract,Helper,Common,Entity,Trait,Traits,Migrations,Tests,ZenchronFileBundle.php}',
            '../src/**/*Interface.php',
            '../src/Common', // Helpers
            '../src/Infrastructure/DependencyInjection',
            '../src/Domain', // Entity
            '../src/Presentation/Form/EasyAdmin', // EasyAdmin
            '../src/Application/**/*Request.php', // DTO
        ]);

    $services
        ->load('Zenchron\\FileBundle\\Presentation\\Api\\', '../src/Presentation/Api/*')
        ->tag('controller.service_arguments');
    $services
        ->load('Zenchron\\FileBundle\\Presentation\\BackOffice\\', '../src/Presentation/BackOffice/*')
        ->tag('controller.service_arguments');

    // Repositories
    $services->set(DoctrineOrmAvailableDatesMediaRepository::class);
    $services->alias(AvailableDatesMediaRepository::class, DoctrineOrmAvailableDatesMediaRepository::class);

    $services->set(DoctrineOrmMimeMediaRepository::class);
    $services->alias(MimeMediaRepository::class, DoctrineOrmMimeMediaRepository::class);

    // Local File Repository
    /*
        $services->set(LocalFileRepository::class);
        $services->alias(FileRepository::class, LocalFileRepository::class);
    */

    // Upload Validator
    $services->set(UploadedFileValidator::class);

    // Resize
    $services
        ->set(FileResizeHandler::class)
        ->args([tagged_iterator(FileBundleExtension::TAG_MEDIA_RESIZE)]);
    $services->set(ImagickGifFileResize::class);
    $services->set(FfmpegGifFileResize::class);
    $services->set(GifsicleGifFileResize::class);
    $services->set(InterventionFileResize::class);

    // Generate Thumbnails
    $services
        ->set(GenerateThumbnailsHandler::class)
        ->args([tagged_iterator(FileBundleExtension::TAG_MEDIA_THUMBNAILS)]);
    $services->set(AbstractGenerateImageThumbnails::class)->abstract();
    $services->set(GenerateImageThumbnails::class)->parent(AbstractGenerateImageThumbnails::class);
    $services->set(GenerateGifImageThumbnails::class)->parent(AbstractGenerateImageThumbnails::class);

    // Compress Thumbnails
    $services
        ->set(FileCompressHandler::class)
        ->args([tagged_iterator(FileBundleExtension::TAG_MEDIA_COMPRESS)]);
    $services->set(SpatieFileCompression::class);
};
