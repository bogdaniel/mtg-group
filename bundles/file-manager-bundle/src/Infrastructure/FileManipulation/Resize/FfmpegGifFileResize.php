<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Infrastructure\FileManipulation\Resize;

use Psr\Log\LoggerInterface;
use Zenchron\FileBundle\Domain\Contract\FileResize;
use Zenchron\FileBundle\Domain\Enum\GifResizeDriver;
use Zenchron\FileBundle\Domain\ValueObject\Dimension;
use Zenchron\FileBundle\Domain\ValueObject\File;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class FfmpegGifFileResize implements FileResize
{


    public function __construct(
        private readonly ?string $imageResizeGifDriver,
        private readonly LoggerInterface $logger
    ) {
    }

    public function resize(string $inputPath, string $outputPath, Dimension $dimension): bool
    {
        $command = <<<END
            ffmpeg -y -i $inputPath
            -filter_complex
            "fps=5,scale={$dimension->width()}:-1:flags=lanczos,split[s0][s1];[s0]palettegen=max_colors=256[p];[s1][p]paletteuse=dither=bayer"
            $outputPath
            END;

        $loggerContext = [
            'with'   => $dimension->width(),
            'input'  => $inputPath,
            'output' => $inputPath,
        ];
        $this->logger->info('Start ffmpeg gif resize', $loggerContext);
        $timeStart = \microtime(true);
        $ffmpeg    = Process::fromShellCommandline(\str_replace(["\r", "\n"], ' ', $command));
        $ffmpeg->run();

        if (!$ffmpeg->isSuccessful()) {
            $exception = new ProcessFailedException($ffmpeg);
            $this->logger->error($exception->getMessage(), $loggerContext);
            throw $exception;
        }

        $this->logger->info(
            'Finish ffmpeg gif resize',
            [...$loggerContext, ...['time' => \microtime(true) - $timeStart.' seconds']]
        );

        return true;
    }

    public function support(File $file): bool
    {
        return $file->extension() === 'gif' && $this->imageResizeGifDriver === GifResizeDriver::FFMPEG->value;
    }
}
