<?php

namespace Core\Domain\Entity;

use DateTime;
use Exception;

use Core\Domain\Validation\DomainValidation;
use Core\Domain\Entity\Traits\MethodsMagicsTrait;
use Core\Domain\Exception\EntityValidationException;

class Subject
{
    use MethodsMagicsTrait;

    /**
     * Constructor class.
     * @param string $description
     * @param DateTime|string $createdAt
     * @param DateTime|string $updatedAt
     * @param int|null $id
     * @throws EntityValidationException
     * @throws Exception
     */
    public function __construct(
        protected string          $description = '',
        protected DateTime|string $createdAt = '',
        protected DateTime|string $updatedAt = '',
        protected int|null        $id = null,
    )
    {
        $this->createdAt = new DateTime($this->createdAt ?? 'now');
        $this->updatedAt = new DateTime($this->updatedAt ?? 'now');
        $this->validate();
    }

    /**
     * Update subject.
     * @param string $description
     * @return void
     * @throws EntityValidationException
     */
    public function update(string $description): void
    {
        $this->description = $description;
        $this->validate();
    }

    /**
     * Validate subject description.
     * @return void
     * @throws EntityValidationException
     */
    private function validate(): void
    {
        DomainValidation::notNull($this->description);
        DomainValidation::stringMaxLength($this->description);
        DomainValidation::stringMinLength($this->description);
    }
}
