<?php

namespace Core\UseCase\DTO\Author\Output;

use DateTime;

class ResponseCreateAuthorDTO
{
    /**
     * Define output transfer data to author.
     * @param int|null $id
     * @param string $name
     * @param string $createdAt
     */
    public function __construct(
        public ?int $id,
        public string $name,
        public string $createdAt,
    )
    {
    }
}