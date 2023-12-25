<?php

namespace Core\UseCase\DTO\Subject\Output;

class ResponseDeleteSubjectDTO
{
    /**
     * Define output to delete one subject
     * @param bool $success
     */
    public function __construct(
        public bool $success
    )
    {
    }
}
