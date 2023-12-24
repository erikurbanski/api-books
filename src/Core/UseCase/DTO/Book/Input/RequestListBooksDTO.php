<?php

namespace Core\UseCase\DTO\Book\Input;

class RequestListBooksDTO
{
    /**
     * Define input to list all books.
     * @param string $filter
     * @param string $order
     * @param int $page
     * @param int $totalPerPage
     */
    public function __construct(
        public string $filter,
        public string $order = 'DESC',
        public int    $page = 1,
        public int    $totalPerPage = 15,
    )
    {
    }
}
