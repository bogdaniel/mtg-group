<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Infrastructure\Filesystem\Exception;

use Zenchron\SharedBundle\Domain\Exception\HttpDomainException;

final class WriteTemporaryFileToOriginException extends HttpDomainException
{
    public function __construct(string $message = 'Could not write temporary file to origin', \Throwable $previous = null)
    {
        parent::__construct($message, self::DEFAULT_STATUS_CODE, 0, $previous);
    }

}
