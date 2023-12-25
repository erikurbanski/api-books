<?php

namespace Core\UseCase\DTO\Subject\Input;

class RequestUpdateSubjectDTO
{
    /**
     * Define input to update subjects.
     */
    public function __construct(
        public int $id,
        public string $description,
    )
    {
    }
}
