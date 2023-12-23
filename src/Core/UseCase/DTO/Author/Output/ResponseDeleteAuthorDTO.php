<?php

namespace Core\UseCase\DTO\Author\Output;

class ResponseDeleteAuthorDTO
{
    /**
     * Define output transfer data delete author.
     * @param bool $success
     */
    public function __construct(
        public bool $success
    )
    {
    }
}