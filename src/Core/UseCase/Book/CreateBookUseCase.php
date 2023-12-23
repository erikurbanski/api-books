<?php

namespace Core\UseCase\Book;

use Core\Domain\Entity\Book;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\UseCase\DTO\Book\Input\RequestCreateBookDTO;
use Core\UseCase\DTO\Book\Output\ResponseCreateBookDTO;

class CreateBookUseCase
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
     * Execute the creation of new book.
     * @param RequestCreateBookDTO $inputs
     * @return ResponseCreateBookDTO
     * @throws EntityValidationException
     */
    public function execute(RequestCreateBookDTO $inputs): ResponseCreateBookDTO
    {
        $book = new Book(
            title: $inputs->title,
            publisher: $inputs->publisher,
            edition: $inputs->edition,
            year: $inputs->year,
            value: $inputs->value,
        );

        $newBook = $this->repository->insert($book);

        return new ResponseCreateBookDTO(
            id: $newBook->id ?? null,
            title: $newBook->title,
            publisher: $newBook->publisher,
            edition: $newBook->edition,
            year: $newBook->year,
            value: $newBook->value,
            createdAt: $newBook->formatCreatedAt(),
            updatedAt: $newBook->formatUpdatedAt(),
        );
    }
}
