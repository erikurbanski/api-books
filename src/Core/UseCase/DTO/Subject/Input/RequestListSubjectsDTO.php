<?php

namespace Core\UseCase\DTO\Subject\Input;

class RequestListSubjectsDTO
{
    /**
     * Define input to paginate subjects.
     * @param string $filter
     * @param string $order
     * @param int $page
     * @param int $totalPerPage
     */
    public function __construct(
        public string $filter,
        public string $order = 'DESC',
        public int    $page = 1,
        public int    $totalPerPage = 15,
    )
    {
    }
}
