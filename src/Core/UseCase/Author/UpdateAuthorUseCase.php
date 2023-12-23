<?php

namespace Core\UseCase\Author;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Repository\AuthorRepositoryInterface;
use Core\UseCase\DTO\Author\Input\RequestUpdateAuthorDTO;
use Core\UseCase\DTO\Author\Output\ResponseUpdateAuthorDTO;

class UpdateAuthorUseCase
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
     * Execute update author.
     * @param RequestUpdateAuthorDTO $inputs
     * @return ResponseUpdateAuthorDTO
     * @throws EntityValidationException
     */
    public function execute(RequestUpdateAuthorDTO $inputs): ResponseUpdateAuthorDTO
    {
        $author = $this->repository->getById($inputs->id);

        $author->update(name: $inputs->name);

        $updatedAuthor = $this->repository->update($author);

        return new ResponseUpdateAuthorDTO(
            id: $updatedAuthor->id,
            name: $updatedAuthor->name,
        );
    }
}