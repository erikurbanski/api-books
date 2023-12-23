<?php

namespace Core\UseCase\DTO\Book\Input;

class RequestGetBookDTO
{
    /**
     * Define input to get one book.
     * @param int $id
     */
    public function __construct(
        public int $id,
    )
    {
    }
}
