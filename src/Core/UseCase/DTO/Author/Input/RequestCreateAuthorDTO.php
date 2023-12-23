<?php

namespace Core\UseCase\DTO\Author\Input;

class RequestCreateAuthorDTO
{
    /**
     * Define input transfer data to author.
     * @param string $name
     */
    public function __construct(
        public string $name,
    )
    {
    }
}