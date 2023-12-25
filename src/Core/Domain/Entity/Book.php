<?php

namespace Core\Domain\Entity;

use DateTime;
use Exception;

use Core\Domain\Validation\DomainValidation;
use Core\Domain\Entity\Traits\MethodsMagicsTrait;
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
     * @param array $authorsId
     * @param array $subjectsId
     * @throws Exception
     * @throws EntityValidationException
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
        protected array           $authorsId = [],
        protected array           $subjectsId = [],
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
     * Set one author in a book.
     * @param int $authorId
     * @return void
     */
    public function addAuthor(int $authorId): void
    {
        $this->authorsId[] = $authorId;
    }

    /**
     * Set one subject in a book.
     * @param int $subjectId
     * @return void
     */
    public function addSubject(int $subjectId): void
    {
        $this->subjectsId[] = $subjectId;
    }

    /**
     * Remove one author in a book.
     * @param int $authorId
     * @return void
     */
    public function removeAuthor(int $authorId): void
    {
        $key = array_search($authorId, $this->authorsId);
        unset($this->authorsId[$key]);
    }

    /**
     * Remove one subject in a book.
     * @param int $subjectId
     * @return void
     */
    public function removeSubject(int $subjectId): void
    {
        $key = array_search($subjectId, $this->subjectsId);
        unset($this->subjectsId[$key]);
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
