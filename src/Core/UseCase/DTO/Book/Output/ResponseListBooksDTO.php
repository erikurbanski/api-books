<?php

namespace Core\UseCase\DTO\Book\Output;

class ResponseListBooksDTO
{
    /**
     * Define output to list all books.
     */
    public function __construct(
        public array $items,
        public int $total,
    )
    {
    }
}
