<?php

namespace Core\UseCase\DTO\Book\Input;

class RequestListBooksDTO
{
    /**
     * Define input to list all books.
     * @param string $filter
     * @param string $order
     */
    public function __construct(
        public string $filter,
        public string $order = 'DESC',
    )
    {
    }
}
