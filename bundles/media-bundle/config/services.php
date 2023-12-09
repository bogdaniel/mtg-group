<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zenchron\FileManagerBundle\Application\FileManipulation\Thumbnails\GenerateThumbnails\AbstractGenerateImageThumbnails;
use Zenchron\FileManagerBundle\Application\FileManipulation\Thumbnails\GenerateThumbnails\GenerateGifImageThumbnails;
use Zenchron\FileManagerBundle\Application\FileManipulation\Thumbnails\GenerateThumbnails\GenerateImageThumbnails;
use Zenchron\FileManagerBundle\Domain\Contract\AvailableDatesMediaRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\Contract\FilePathResolverInterface;
use Zenchron\FileManagerBundle\Domain\Contract\FileRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\Contract\FileUrlResolverInterface;
use Zenchron\FileManagerBundle\Domain\Contract\MimeMediaRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\Service\FileCompressHandler;
use Zenchron\FileManagerBundle\Domain\Service\FileResizeHandler;
use Zenchron\FileManagerBundle\Domain\Service\GenerateThumbnailsHandler;
use Zenchron\FileManagerBundle\Infrastructure\DependencyInjection\MediaBundleExtension;
use Zenchron\FileManagerBundle\Infrastructure\FileManipulation\Compression\SpatieFileCompression;
use Zenchron\FileManagerBundle\Infrastructure\FileManipulation\Thumbnails\Resize\FfmpegGifFileResize;
use Zenchron\FileManagerBundle\Infrastructure\FileManipulation\Thumbnails\Resize\GifsicleGifFileResize;
use Zenchron\FileManagerBundle\Infrastructure\FileManipulation\Thumbnails\Resize\ImagickGifFileResize;
use Zenchron\FileManagerBundle\Infrastructure\FileManipulation\Thumbnails\Resize\InterventionFileResize;
use Zenchron\FileManagerBundle\Infrastructure\Filesystem\Local\LocalFilePathResolver;
use Zenchron\FileManagerBundle\Infrastructure\Filesystem\Local\LocalFileRepository;
use Zenchron\FileManagerBundle\Infrastructure\Filesystem\Local\LocalFileUrlResolver;
use Zenchron\FileManagerBundle\Infrastructure\Persistence\Orm\Repository\DoctrineOrmAvailableDatesMediaRepository;
use Zenchron\FileManagerBundle\Infrastructure\Persistence\Orm\Repository\DoctrineOrmMimeMediaRepository;
use Zenchron\FileManagerBundle\Infrastructure\Validation\UploadedFileValidator;

return static function (ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc
        ->autowire(); // Automatically injects dependencies in your services


    $services
        ->load('Zenchron\\FileManagerBundle\\', '../src/*')
        ->exclude([
            '../src/{DependencyInjection,DQL,Contract,Helper,Common,Entity,Trait,Traits,Migrations,Tests,ZenchronFileManagerBundle.php}',
            '../src/**/*Interface.php',
            '../src/Common', // Helpers
            '../src/Infrastructure/DependencyInjection',
            '../src/Domain', // Entity
            '../src/Presentation/Form/EasyAdmin', // EasyAdmin
            '../src/Application/**/*Request.php', // DTO
        ]);

    $services
        ->load('Zenchron\\FileManagerBundle\\Presentation\\Api\\', '../src/Presentation/Api/*')
        ->tag('controller.service_arguments');
    $services
        ->load('Zenchron\\FileManagerBundle\\Presentation\\BackOffice\\', '../src/Presentation/BackOffice/*')
        ->tag('controller.service_arguments');

    // Repositories
    $services->set(DoctrineOrmAvailableDatesMediaRepository::class);
    $services->alias(AvailableDatesMediaRepositoryInterface::class, DoctrineOrmAvailableDatesMediaRepository::class);

    $services->set(DoctrineOrmMimeMediaRepository::class);
    $services->alias(MimeMediaRepositoryInterface::class, DoctrineOrmMimeMediaRepository::class);

    // Local File Repository
    $services->set(LocalFileRepository::class);
    $services->alias(FileRepositoryInterface::class, LocalFileRepository::class);

    // Upload Validator
    $services->set(UploadedFileValidator::class);

    // Path Resolver
    $services->set(LocalFilePathResolver::class);
    $services->alias(FilePathResolverInterface::class, LocalFilePathResolver::class);

    // Url Resolver
    $services->set(LocalFileUrlResolver::class);
    $services->alias(FileUrlResolverInterface::class, LocalFileUrlResolver::class);

    // Resize
    $services
        ->set(FileResizeHandler::class)
        ->args([tagged_iterator(MediaBundleExtension::TAG_MEDIA_RESIZE)]);
    $services->set(ImagickGifFileResize::class);
    $services->set(FfmpegGifFileResize::class);
    $services->set(GifsicleGifFileResize::class);
    $services->set(InterventionFileResize::class);

    // Generate Thumbnails
    $services
        ->set(GenerateThumbnailsHandler::class)
        ->args([tagged_iterator(MediaBundleExtension::TAG_MEDIA_THUMBNAILS)]);
    $services->set(AbstractGenerateImageThumbnails::class)->abstract();
    $services->set(GenerateImageThumbnails::class)->parent(AbstractGenerateImageThumbnails::class);
    $services->set(GenerateGifImageThumbnails::class)->parent(AbstractGenerateImageThumbnails::class);

    // Compress Thumbnails
    $services
        ->set(FileCompressHandler::class)
        ->args([tagged_iterator(MediaBundleExtension::TAG_MEDIA_COMPRESS)]);
    $services->set(SpatieFileCompression::class);
};
