<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Infrastructure\Filesystem\Exception;

use Zenchron\SharedBundle\Domain\Exception\HttpDomainException;

final class CopyFileException extends HttpDomainException
{
    /**
     * @param string $message
     * @param \Throwable|null $previous
     */
    public function __construct(string $message, ?\Throwable $previous = null)
    {
        parent::__construct($message, self::DEFAULT_STATUS_CODE, 0, $previous);
    }

}
