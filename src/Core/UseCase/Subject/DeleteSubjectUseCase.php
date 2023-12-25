<?php

namespace Core\UseCase\Subject;

use Core\Domain\Repository\SubjectRepositoryInterface;
use Core\UseCase\DTO\Subject\Input\RequestGetSubjectDTO;
use Core\UseCase\DTO\Subject\Output\ResponseDeleteSubjectDTO;

class DeleteSubjectUseCase
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
     * Delete subject.
     * @param RequestGetSubjectDTO $inputs
     * @return ResponseDeleteSubjectDTO
     */
    public function execute(RequestGetSubjectDTO $inputs): ResponseDeleteSubjectDTO
    {
        $deleted = $this->repository->delete($inputs->id);

        return new ResponseDeleteSubjectDTO($deleted);
    }
}
