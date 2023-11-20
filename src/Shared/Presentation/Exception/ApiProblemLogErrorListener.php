<?php
declare(strict_types=1);

namespace App\Shared\Presentation\Exception;

use App\Shared\Domain\Exception\ApiProblem\ApiProblemException;
use Symfony\Component\HttpKernel\EventListener\ErrorListener;

class ApiProblemLogErrorListener extends ErrorListener
{
    public function logException(\Throwable $exception, string $message, string $logLevel = null): void
    {
        if ($exception instanceof ApiProblemException) {
            $this->logger->debug('ApiProblemException caught and JSON response send', ['exception' => $exception]);
            return;
        }

        parent::logException($exception, $message, $logLevel);
    }
}
