<?php

namespace Core\UseCase\DTO\Author\Output;

use DateTime;

class ResponseGetAuthorDTO
{
    /**
     * Define output to get one author.
     * @param int $id
     * @param string $name
     * @param string $createdAt
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $createdAt,
    )
    {
    }
}