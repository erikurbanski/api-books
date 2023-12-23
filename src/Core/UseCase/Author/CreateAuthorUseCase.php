<?php

namespace Core\UseCase\Author;

use Core\Domain\Entity\Author;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Repository\AuthorRepositoryInterface;
use Core\UseCase\DTO\Author\Input\RequestCreateAuthorDTO;
use Core\UseCase\DTO\Author\Output\ResponseCreateAuthorDTO;

class CreateAuthorUseCase
{
    /**
     * Constructor class.
     * @param AuthorRepositoryInterface $repository
     */
    public function __construct(
        protected AuthorRepositoryInterface $repository
    )
    {
    }

    /**
     * Execute the creation of new author.
     * @param RequestCreateAuthorDTO $requestAuthorDTO
     * @return ResponseCreateAuthorDTO
     * @throws EntityValidationException
     */
    public function execute(RequestCreateAuthorDTO $requestAuthorDTO): ResponseCreateAuthorDTO
    {
        $author = new Author(
            name: $requestAuthorDTO->name,
        );

        $newAuthor = $this->repository->insert($author);

        return new ResponseCreateAuthorDTO(
            id: $newAuthor->id ?? null,
            name: $newAuthor->name,
            createdAt: $newAuthor->formatCreatedAt(),
        );
    }
}