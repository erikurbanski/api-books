<?php

namespace Core\UseCase\DTO\Book\Output;

class ResponseListBooksDTO
{
    /**
     * Define output to list all books.
     * @param array $items
     * @param int $total
     * @param int $last_page
     * @param int $first_page
     * @param int $per_page
     * @param int $to
     * @param int $from
     */
    public function __construct(
        public array $items,
        public int $total,
        public int $last_page,
        public int $first_page,
        public int $per_page,
        public int $current_page,
        public int $to,
        public int $from,
    )
    {
    }
}
