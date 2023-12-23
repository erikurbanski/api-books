<?php

namespace Core\UseCase\DTO\Book\Output;

class ResponseCreateBookDTO
{
    /**
     * Define output transfer data to create a book.
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $publisher,
        public int    $edition,
        public string $year,
        public float  $value,
        public string $createdAt = '',
        public string $updatedAt = '',
    )
    {
    }
}
