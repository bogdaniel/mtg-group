<?php
declare(strict_types=1);

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class QuestionsAnsweredEvent extends Event
{
    public const NAME = 'theme.questions_answered';

    protected string $packageName;

    public function __construct(string $packageName)
    {
        $this->packageName = $packageName;
    }

    public function getPackageName(): string
    {
        return $this->packageName;
    }
}
