<?php

namespace Core\UseCase\DTO\Author\Output;

class ResponseUpdateAuthorDTO
{
    /**
     * Define output to update authors.
     */
    public function __construct(
        public int $id,
        public string $name,
    )
    {
    }
}