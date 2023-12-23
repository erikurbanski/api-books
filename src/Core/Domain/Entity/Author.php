<?php

namespace Core\Domain\Entity;

use DateTime;
use Exception;

use Core\Domain\Validation\DomainValidation;
use Core\Domain\Entity\Traits\MethodsMagicsTrait;
use Core\Domain\Exception\EntityValidationException;

class Author
{
    use MethodsMagicsTrait;

    /**
     * Constructor class.
     * @param string $name
     * @param int|null $id
     * @param DateTime|string $createdAt
     * @throws EntityValidationException
     * @throws Exception
     */
    public function __construct(
        protected string          $name = '',
        protected int|null        $id = null,
        protected DateTime|string $createdAt = '',
    )
    {
        $this->createdAt = new DateTime($this->createdAt ?? 'now');
        $this->validate();
    }

    /**
     * Update author.
     * @param string $name
     * @return void
     * @throws EntityValidationException
     */
    public function update(string $name): void
    {
        $this->name = $name;
        $this->validate();
    }

    /**
     * Validate author name.
     * @return void
     * @throws EntityValidationException
     */
    private function validate(): void
    {
        DomainValidation::notNull($this->name);
        DomainValidation::stringMaxLength($this->name);
        DomainValidation::stringMinLength($this->name);
    }
}