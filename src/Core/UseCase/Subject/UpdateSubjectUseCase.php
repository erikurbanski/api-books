<?php

namespace Core\UseCase\Subject;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Repository\SubjectRepositoryInterface;
use Core\UseCase\DTO\Subject\Input\RequestUpdateSubjectDTO;
use Core\UseCase\DTO\Subject\Output\ResponseUpdateSubjectDTO;

class UpdateSubjectUseCase
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
     * Execute update subject.
     * @param RequestUpdateSubjectDTO $inputs
     * @return ResponseUpdateSubjectDTO
     * @throws EntityValidationException
     */
    public function execute(RequestUpdateSubjectDTO $inputs): ResponseUpdateSubjectDTO
    {
        $subject = $this->repository->getById($inputs->id);

        $subject->update(description: $inputs->description);

        $updatedSubject = $this->repository->update($subject);

        return new ResponseUpdateSubjectDTO(
            id: $updatedSubject->id,
            description: $updatedSubject->description,
            createdAt: $updatedSubject->formatCreatedAt(),
            updatedAt: $updatedSubject->formatUpdatedAt(),
        );
    }
}
