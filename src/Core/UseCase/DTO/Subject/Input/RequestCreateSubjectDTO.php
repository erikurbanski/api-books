<?php

namespace Core\UseCase\DTO\Subject\Input;

class RequestCreateSubjectDTO
{
    /**
     * Define input transfer data to subject.
     * @param string $description
     */
    public function __construct(
        public string $description,
    )
    {
    }
}
