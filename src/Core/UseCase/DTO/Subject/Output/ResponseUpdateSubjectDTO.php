<?php

namespace Core\UseCase\DTO\Subject\Output;

class ResponseUpdateSubjectDTO
{
    /**
     * Define output to update subjects.
     * @param int $id
     * @param string $description
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(
        public int $id,
        public string $description,
        public string $createdAt = '',
        public string $updatedAt = '',
    )
    {
    }
}
