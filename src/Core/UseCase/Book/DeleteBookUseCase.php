<?php

namespace Core\UseCase\Book;

use Core\Domain\Repository\BookRepositoryInterface;
use Core\UseCase\DTO\Book\Input\RequestGetBookDTO;
use Core\UseCase\DTO\Book\Output\ResponseDeleteBookDTO;

class DeleteBookUseCase
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
     * Delete book.
     * @param RequestGetBookDTO $inputs
     * @return ResponseDeleteBookDTO
     */
    public function execute(RequestGetBookDTO $inputs): ResponseDeleteBookDTO
    {
        $bookDelete = $this->repository->delete($inputs->id);

        return new ResponseDeleteBookDTO($bookDelete);
    }
}
