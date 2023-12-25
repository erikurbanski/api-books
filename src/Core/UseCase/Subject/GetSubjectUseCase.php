<?php

namespace Core\UseCase\Subject;

use Core\Domain\Repository\SubjectRepositoryInterface;
use Core\UseCase\DTO\Subject\Input\RequestGetSubjectDTO;
use Core\UseCase\DTO\Subject\Output\ResponseGetSubjectDTO;

class GetSubjectUseCase
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
     * Get subject by id.
     * @param RequestGetSubjectDTO $inputs
     * @return ResponseGetSubjectDTO
     */
    public function execute(RequestGetSubjectDTO $inputs): ResponseGetSubjectDTO
    {
        $subject = $this->repository->getById($inputs->id);

        return new ResponseGetSubjectDTO(
            id: $subject->id ?? null,
            description: $subject->description,
            createdAt: $subject->formatCreatedAt(),
            updatedAt: $subject->formatUpdatedAt(),
        );
    }
}
