<?php

namespace Core\UseCase\Book;

use Core\Domain\Repository\BookRepositoryInterface;
use Core\UseCase\DTO\Book\Input\RequestListBooksDTO;
use Core\UseCase\DTO\Book\Output\ResponseListBooksDTO;

class ListBooksUseCase
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
     * List all results to books.
     * @param RequestListBooksDTO $inputs
     * @return ResponseListBooksDTO
     */
    public function execute(RequestListBooksDTO $inputs): ResponseListBooksDTO
    {
        $books = $this->repository->findAll(
            filter: $inputs->filter,
            order: $inputs->order,
        );

        return new ResponseListBooksDTO(
            items: $books,
            total: count($books),
        );
    }
}
