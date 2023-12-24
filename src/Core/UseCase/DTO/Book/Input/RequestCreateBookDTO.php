<?php

namespace Core\UseCase\DTO\Book\Input;

class RequestCreateBookDTO
{
    /**
     * Define input transfer data to create a book.
     * @param string $title
     * @param string $publisher
     * @param int $edition
     * @param string $year
     * @param float $value
     * @param array $authorsId
     */
    public function __construct(
        public string $title,
        public string $publisher,
        public int    $edition,
        public string $year,
        public float  $value,
        public array  $authorsId = [],
    )
    {
    }
}
