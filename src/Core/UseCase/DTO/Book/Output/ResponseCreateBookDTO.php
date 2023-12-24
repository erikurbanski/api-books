<?php

namespace Core\UseCase\DTO\Book\Output;

class ResponseCreateBookDTO
{
    /**
     * Define output transfer data to create a book.
     * @param int|null $id
     * @param string $title
     * @param string $publisher
     * @param int $edition
     * @param string $year
     * @param float $value
     * @param string $createdAt
     * @param string $updatedAt
     * @param array $authorsId
     */
    public function __construct(
        public ?int   $id,
        public string $title,
        public string $publisher,
        public int    $edition,
        public string $year,
        public float  $value,
        public string $createdAt = '',
        public string $updatedAt = '',
        public array  $authorsId = [],
    )
    {
    }
}
