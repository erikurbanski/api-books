<?php

namespace Core\UseCase\Subject;

use Core\Domain\Entity\Subject;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Repository\SubjectRepositoryInterface;
use Core\UseCase\DTO\Subject\Input\RequestCreateSubjectDTO;
use Core\UseCase\DTO\Subject\Output\ResponseCreateSubjectDTO;

class CreateSubjectUseCase
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
     * Execute the creation of new subject.
     * @param RequestCreateSubjectDTO $inputs
     * @return ResponseCreateSubjectDTO
     * @throws EntityValidationException
     */
    public function execute(RequestCreateSubjectDTO $inputs): ResponseCreateSubjectDTO
    {
        $subject = new Subject(
            description: $inputs->description,
        );

        $newSubject = $this->repository->insert($subject);

        return new ResponseCreateSubjectDTO(
            id: $newSubject->id ?? null,
            description: $newSubject->description,
            createdAt: $newSubject->formatCreatedAt(),
            updatedAt: $newSubject->formatUpdatedAt(),
        );
    }
}
