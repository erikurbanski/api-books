<?php

namespace Core\UseCase\DTO\Book\Input;

class RequestUpdateBookDTO
{
    /**
     * Define input to update one book.
     */
    public function __construct(
        public int    $id,
        public string $title,
        public string $publisher,
        public int    $edition,
        public string $year,
        public float  $value,
        public array  $authorsId,
        public array  $subjectsId,
    )
    {
    }
}
