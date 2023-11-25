<?php
declare(strict_types=1);

namespace App\FileManager\Infrastructure\FileManipulation\Thumbnails\Resize;

use Psr\Log\LoggerInterface;
use App\FileManager\Domain\Contract\FileResizeInterface;
use App\FileManager\Domain\Enum\GifResizeDriver;
use App\FileManager\Domain\ValueObject\Dimension;
use App\FileManager\Domain\ValueObject\File;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class GifsicleGifFileResize implements FileResizeInterface
{


    public function __construct(
        private readonly ?string $imageResizeGifDriver,
        private readonly LoggerInterface $logger
    ) {
    }

    public function resize(string $inputPath, string $outputPath, Dimension $dimension): bool
    {
        $command = <<<END
            gifsicle --resize-fit-width {$dimension->width()} -i $inputPath > $outputPath
            END;

        $loggerContext = [
            'with'   => $dimension->width(),
            'input'  => $inputPath,
            'output' => $inputPath,
        ];
        $this->logger->info('Start gifsicle gif resize', $loggerContext);
        $timeStart = \microtime(true);
        $ffmpeg    = Process::fromShellCommandline(\str_replace(["\r", "\n"], ' ', $command));
        $ffmpeg->run();

        if (!$ffmpeg->isSuccessful()) {
            $exception = new ProcessFailedException($ffmpeg);
            $this->logger->error($exception->getMessage(), $loggerContext);
            throw $exception;
        }

        $this->logger->info(
            'Finish gifsicle gif resize',
            [...$loggerContext, ...['time' => \microtime(true) - $timeStart.' seconds']]
        );

        return true;
    }

    public function support(File $file): bool
    {
        return $file->extension() === 'gif' && $this->imageResizeGifDriver === GifResizeDriver::GIFSICLE->value;
    }
}
