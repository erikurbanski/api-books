<?php

namespace Core\UseCase\Subject;

use Core\Domain\Repository\SubjectRepositoryInterface;
use Core\UseCase\DTO\Subject\Input\RequestListSubjectsDTO;
use Core\UseCase\DTO\Subject\Output\ResponseListSubjectsDTO;

class ListSubjectsUseCase
{
    /**
     * Constructor class.
     * @param SubjectRepositoryInterface $repository
     */
    public function __construct(
        protected SubjectRepositoryInterface $repository
    )
    {
    }

    /**
     * Paginate results to subjects.
     * @param RequestListSubjectsDTO $inputs
     * @return ResponseListSubjectsDTO
     */
    public function execute(RequestListSubjectsDTO $inputs): ResponseListSubjectsDTO
    {
        $subjects = $this->repository->paginate(
            filter: $inputs->filter,
            order: $inputs->order,
            page: $inputs->page,
            totalPerPage: $inputs->totalPerPage,
        );

        return new ResponseListSubjectsDTO(
            items: $subjects->items(),
            total: $subjects->total(),
            last_page: $subjects->lastPage(),
            first_page: $subjects->firstPage(),
            per_page: $subjects->perPage(),
            current_page: $subjects->currentPage(),
            to: $subjects->to(),
            from: $subjects->from(),
        );
    }
}
