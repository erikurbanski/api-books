<?php

namespace Core\UseCase\DTO\Author\Input;

class RequestGetAuthorDTO
{
    /**
     * Define input to get one author.
     * @param int $id
     */
    public function __construct(
        public int $id,
    )
    {
    }
}