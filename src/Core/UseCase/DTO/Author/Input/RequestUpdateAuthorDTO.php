<?php

namespace Core\UseCase\DTO\Author\Input;

class RequestUpdateAuthorDTO
{
    /**
     * Define input to update authors.
     */
    public function __construct(
        public int $id,
        public string $name,
    )
    {
    }
}