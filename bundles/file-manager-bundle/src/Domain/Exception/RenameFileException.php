<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Domain\Exception;

use Zenchron\SharedBundle\Domain\Exception\HttpDomainException;

final class RenameFileException extends HttpDomainException
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
