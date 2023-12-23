<?php

namespace Core\UseCase\Book;

use Core\Domain\Repository\BookRepositoryInterface;
use Core\UseCase\DTO\Book\Input\RequestGetBookDTO;
use Core\UseCase\DTO\Book\Output\ResponseGetBookDTO;

class GetBookUseCase
{
    /**
     * Constructor class.
     * @param BookRepositoryInterface $repository
     */
    public function __construct(
        protected BookRepositoryInterface $repository
    )
    {
    }

    /**
     * Get book by id.
     * @param RequestGetBookDTO $inputs
     * @return ResponseGetBookDTO
     */
    public function execute(RequestGetBookDTO $inputs): ResponseGetBookDTO
    {
        $book = $this->repository->getById($inputs->id);

        return new ResponseGetBookDTO(
            id: $book->id,
            title: $book->title,
            publisher: $book->publisher,
            edition: $book->edition,
            year: $book->year,
            value: $book->value,
            createdAt: $book->formatCreatedAt(),
            updatedAt: $book->formatUpdatedAt(),
        );
    }
}
