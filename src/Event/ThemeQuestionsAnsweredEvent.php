<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class ThemeQuestionsAnsweredEvent extends Event
{
    public const NAME = 'theme.questions.answered';

    protected array $answers;

    public function __construct(array $answers)
    {
        $this->answers = $answers;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }
}
