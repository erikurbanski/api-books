<?php

namespace Core\UseCase\DTO\Subject\Output;

class ResponseListSubjectsDTO
{
    /**
     * Define output to pagination subjects.
     */
    public function __construct(
        public array $items,
        public int $total,
        public int $last_page,
        public int $first_page,
        public int $per_page,
        public int $to,
        public int $from,
    )
    {
    }
}
