<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MethodsMagicsTrait;
use DateTime;
use Exception;

use Core\Domain\Validation\DomainValidation;
use Core\Domain\Exception\EntityValidationException;

class Book
{
    use MethodsMagicsTrait;

    /**
     * Constructor class.
     * @param string $title
     * @param string $publisher
     * @param int $edition
     * @param string $year
     * @param float $value
     * @param DateTime|string $createdAt
     * @param DateTime|string $updatedAt
     * @param int|null $id
     * @throws Exception
     */
    public function __construct(
        protected string          $title = '',
        protected string          $publisher = '',
        protected int             $edition = 1,
        protected string          $year = '',
        protected float           $value = 0,
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
     * Update data book.
     * @param string $title
     * @param string $publisher
     * @param int $edition
     * @param string $year
     * @param float $value
     * @return void
     */
    public function update(string $title, string $publisher, int $edition, string $year, float $value): void
    {
        $this->title = $title;
        $this->publisher = $publisher;
        $this->edition = $edition;
        $this->year = $year;
        $this->value = $value;
    }

    /**
     * Validate any fields in book.
     * @return void
     * @throws EntityValidationException
     */
    protected function validate(): void
    {
        DomainValidation::notNull($this->year);
        DomainValidation::notNull($this->title);
        DomainValidation::notNull($this->publisher);

        DomainValidation::stringMaxLength($this->title);
        DomainValidation::stringMinLength($this->title);

        DomainValidation::notNegative($this->value);
        DomainValidation::notNegative($this->edition);

        DomainValidation::validYear($this->year);
    }
}
