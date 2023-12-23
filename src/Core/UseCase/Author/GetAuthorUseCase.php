<?php

namespace Core\UseCase\Author;

use Core\Domain\Repository\AuthorRepositoryInterface;
use Core\UseCase\DTO\Author\Input\RequestGetAuthorDTO;
use Core\UseCase\DTO\Author\Output\ResponseGetAuthorDTO;

class GetAuthorUseCase
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
     * Get author by id.
     * @param RequestGetAuthorDTO $requestAuthorDTO
     * @return ResponseGetAuthorDTO
     */
    public function execute(RequestGetAuthorDTO $requestAuthorDTO): ResponseGetAuthorDTO
    {
        $author = $this->repository->getById($requestAuthorDTO->id);

        return new ResponseGetAuthorDTO(
            id: $author->id,
            name: $author->name,
            createdAt: $author->formatCreatedAt(),
        );
    }
}