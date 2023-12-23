<?php

namespace Core\UseCase\Author;

use Core\Domain\Repository\AuthorRepositoryInterface;
use Core\UseCase\DTO\Author\Input\RequestGetAuthorDTO;
use Core\UseCase\DTO\Author\Output\ResponseDeleteAuthorDTO;

class DeleteAuthorUseCase
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
     * Delete author.
     * @param RequestGetAuthorDTO $inputs
     * @return ResponseDeleteAuthorDTO
     */
    public function execute(RequestGetAuthorDTO $inputs): ResponseDeleteAuthorDTO
    {
        $authorDelete = $this->repository->delete($inputs->id);

        return new ResponseDeleteAuthorDTO($authorDelete);
    }
}