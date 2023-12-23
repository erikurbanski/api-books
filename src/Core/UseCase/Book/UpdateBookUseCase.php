<?php

namespace Core\UseCase\Book;

use Core\Domain\Repository\BookRepositoryInterface;
use Core\UseCase\DTO\Book\Input\RequestUpdateBookDTO;
use Core\UseCase\DTO\Book\Output\ResponseUpdateBookDTO;

class UpdateBookUseCase
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
     * Execute update author.
     * @param RequestUpdateBookDTO $inputs
     * @return ResponseUpdateBookDTO
     */
    public function execute(RequestUpdateBookDTO $inputs): ResponseUpdateBookDTO
    {
        $book = $this->repository->getById($inputs->id);
        $book->update(
            title: $inputs->title,
            publisher: $inputs->publisher,
            edition: $inputs->edition,
            year: $inputs->year,
            value: $inputs->value,
        );

        $updatedBook = $this->repository->update($book);

        return new ResponseUpdateBookDTO(
            id: $updatedBook->id,
            title: $updatedBook->title,
            publisher: $updatedBook->publisher,
            edition: $updatedBook->edition,
            year: $updatedBook->year,
            value: $updatedBook->value,
            createdAt: $updatedBook->formatCreatedAt(),
            updatedAt: $updatedBook->formatUpdatedAt(),
        );
    }
}
