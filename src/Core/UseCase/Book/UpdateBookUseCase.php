<?php

namespace Core\UseCase\Book;

use Throwable;
use Core\Domain\Exception\NotFoundRegisterException;
use Core\Domain\Repository\AuthorRepositoryInterface;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\Repository\SubjectRepositoryInterface;
use Core\UseCase\Interfaces\TransactionInterface;
use Core\UseCase\DTO\Book\Input\RequestUpdateBookDTO;
use Core\UseCase\DTO\Book\Output\ResponseUpdateBookDTO;

class UpdateBookUseCase
{
    /**
     * Constructor class.
     * @param BookRepositoryInterface $bookRepository
     * @param AuthorRepositoryInterface $authorRepository
     * @param SubjectRepositoryInterface $subjectRepository
     * @param TransactionInterface $transaction
     */
    public function __construct(
        protected BookRepositoryInterface    $bookRepository,
        protected AuthorRepositoryInterface  $authorRepository,
        protected SubjectRepositoryInterface $subjectRepository,
        protected TransactionInterface       $transaction,
    )
    {
    }

    /**
     * Execute update book.
     * @param RequestUpdateBookDTO $inputs
     * @return ResponseUpdateBookDTO
     * @throws Throwable
     */
    public function execute(RequestUpdateBookDTO $inputs): ResponseUpdateBookDTO
    {
        try {
            $book = $this->bookRepository->getById($inputs->id);
            $book->update(
                title: $inputs->title,
                publisher: $inputs->publisher,
                edition: $inputs->edition,
                year: $inputs->year,
                value: $inputs->value,
            );

            if (count($inputs->authorsId) > 0) {
                foreach ($inputs->authorsId as $authorId) {
                    $book->addAuthor($authorId);
                }
            }

            if (count($inputs->subjectsId) > 0) {
                foreach ($inputs->subjectsId as $subjectId) {
                    $book->addSubject($subjectId);
                }
            }

            $this->validateAuthors($inputs->authorsId);
            $this->validateSubjects($inputs->subjectsId);

            $updatedBook = $this->bookRepository->update($book);

            return new ResponseUpdateBookDTO(
                id: $updatedBook->id,
                title: $updatedBook->title,
                publisher: $updatedBook->publisher,
                edition: $updatedBook->edition,
                year: $updatedBook->year,
                value: $updatedBook->value,
                createdAt: $updatedBook->formatCreatedAt(),
                updatedAt: $updatedBook->formatUpdatedAt(),
                authorsId: $updatedBook->authorsId,
                subjectsId: $updatedBook->subjectsId,
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
                count($arrayDiff) > 1 ? 'Author' : 'Authors',
                implode(', ', $arrayDiff)
            );

            throw new NotFoundRegisterException($message);
        }
    }

    /**
     * Validate list subject id's.
     * @param array $subjectsId
     * @return void
     * @throws NotFoundRegisterException
     */
    protected function validateSubjects(array $subjectsId = []): void
    {
        $subjects = $this->subjectRepository->getIdsFromListIds($subjectsId);

        $arrayDiff = array_diff($subjectsId, $subjects);
        if (count($arrayDiff)) {
            $message = sprintf(
                '%s %s not found.',
                count($arrayDiff) > 1 ? 'Subjects' : 'Subject',
                implode(', ', $arrayDiff)
            );

            throw new NotFoundRegisterException($message);
        }
    }
}
