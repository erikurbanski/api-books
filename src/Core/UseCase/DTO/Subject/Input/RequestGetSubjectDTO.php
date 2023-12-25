<?php

namespace Core\UseCase\DTO\Subject\Input;

class RequestGetSubjectDTO
{
    /**
     * Define input to get one subject.
     * @param int $id
     */
    public function __construct(
        public int $id,
    )
    {
    }
}
