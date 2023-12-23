<?php

namespace Core\UseCase\DTO\Book\Output;

class ResponseDeleteBookDTO
{
    /**
     * Define output to delete one book.
     * @param bool $success
     */
    public function __construct(
        public bool $success
    )
    {
    }
}
