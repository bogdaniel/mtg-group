<?php
declare(strict_types=1);

namespace Zenchron\SharedBundle\Presentation\Attributes\File;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_PARAMETER)]
class File
{
    private ?string $constraint;
    /** @var string[]|null  */
    private ?array $groups;

    /**
     * @param string|null $constraint
     * @param string[]|null $groups
     */
    public function __construct(?string $constraint = null, ?array $groups = null)
    {
        $this->constraint = $constraint;
        $this->groups     = $groups;
    }

    public function getConstraint(): ?string
    {
        return $this->constraint;
    }

    /**
     * @return string[]|null
     */
    public function getGroups(): ?array
    {
        return $this->groups;
    }

}
