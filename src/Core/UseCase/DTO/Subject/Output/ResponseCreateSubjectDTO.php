<?php

namespace Core\UseCase\DTO\Subject\Output;

class ResponseCreateSubjectDTO
{
    /**
     * Define output transfer data to subject.
     * @param int|null $id
     * @param string $description
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(
        public ?int $id,
        public string $description,
        public string $createdAt = '',
        public string $updatedAt = '',
    )
    {
    }
}
