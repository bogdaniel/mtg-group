<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Exception;

use App\Shared\Domain\Exception\HttpDomainException;

final class RenameFileException extends HttpDomainException
{
    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, self::DEFAULT_STATUS_CODE, $code, $previous);
    }

}
