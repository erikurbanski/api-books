<?php

namespace Core\UseCase\Book;

use Core\Domain\Exception\NotFoundRegisterException;
use Throwable;

use Core\Domain\Entity\Book;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Repository\AuthorRepositoryInterface;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\UseCase\Interfaces\TransactionInterface;
use Core\UseCase\DTO\Book\Input\RequestCreateBookDTO;
use Core\UseCase\DTO\Book\Output\ResponseCreateBookDTO;

class CreateBookUseCase
{
    /**
     * Constructor class.
     * @param BookRepositoryInterface $bookRepository
     * @param AuthorRepositoryInterface $authorRepository
     * @param TransactionInterface $transaction
     */
    public function __construct(
        protected BookRepositoryInterface   $bookRepository,
        protected AuthorRepositoryInterface $authorRepository,
        protected TransactionInterface      $transaction,
    )
    {
    }

    /**
     * Execute the creation of new book.
     * @param RequestCreateBookDTO $inputs
     * @return ResponseCreateBookDTO
     * @throws EntityValidationException
     * @throws Throwable
     */
    public function execute(RequestCreateBookDTO $inputs): ResponseCreateBookDTO
    {
        try {
            $book = new Book(
                title: $inputs->title,
                publisher: $inputs->publisher,
                edition: $inputs->edition,
                year: $inputs->year,
                value: $inputs->value,
                authorsId: $inputs->authorsId,
            );

            $this->validateAuthors($inputs->authorsId);
            $newBook = $this->bookRepository->insert($book);

            $this->transaction->commit();

            return new ResponseCreateBookDTO(
                id: $newBook->id ?? null,
                title: $newBook->title,
                publisher: $newBook->publisher,
                edition: $newBook->edition,
                year: $newBook->year,
                value: $newBook->value,
                createdAt: $newBook->formatCreatedAt(),
                updatedAt: $newBook->formatUpdatedAt(),
                authorsId: $newBook->authorsId,
            );

        } catch (Throwable $th) {
            $this->transaction->rollback();
            throw $th;
        }
    }

    /**
     * Validate list author id's.
     * @param array $authorsId
     * @return void
     * @throws NotFoundRegisterException
     */
    protected function validateAuthors(array $authorsId = []): void
    {
        $authors = $this->authorRepository->getIdsFromListIds($authorsId);

        $arrayDiff = array_diff($authorsId, $authors);
        if (count($arrayDiff)) {
            $message = sprintf(
                '%s %s not found.',
                count($arrayDiff) > 1 ? 'Categories' : 'Category',
                implode(', ', $arrayDiff)
            );

            throw new NotFoundRegisterException($message);
        }
    }
}
