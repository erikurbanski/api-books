<?php

namespace App\Repositories\Eloquent;

use App\Models\Book as BookModel;
use Core\Domain\Entity\Book as BookEntity;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\Exception\NotFoundRegisterException;
use Core\Domain\Exception\EntityValidationException;

class BookEloquentRepository implements BookRepositoryInterface
{
    /**
     * Constructor class.
     * @param BookModel $bookModel
     */
    public function __construct(
        protected BookModel $bookModel
    )
    {
    }

    /**
     * Convert model object in entity.
     * @param object $object
     * @return BookEntity
     * @throws EntityValidationException
     */
    private function toBook(object $object): BookEntity
    {
        return new BookEntity(
            title: $object->title,
            publisher: $object->publisher,
            edition: $object->edition,
            year: $object->year,
            value: $object->value,
            id: $object->id,
        );
    }

    /**
     * Return one book from database.
     * @param int $id
     * @return BookEntity
     * @throws NotFoundRegisterException
     * @throws EntityValidationException
     */
    public function getById(int $id): BookEntity
    {
        $book = $this->bookModel->query()->find($id);

        if (!$book) {
            throw new NotFoundRegisterException(message: 'Register not found!');
        }

        return $this->toBook($book);
    }

    /**
     * Insert new book in database.
     * @param BookEntity $book
     * @return BookEntity
     * @throws EntityValidationException
     */
    public function insert(BookEntity $book): BookEntity
    {
        $book = $this->bookModel->query()->create([
            'title' => $book->title,
            'publisher' => $book->publisher,
            'edition' => $book->edition,
            'year' => $book->year,
            'value' => $book->value,
        ]);

        return $this->toBook($book);
    }

    /**
     * Update one book in database.
     * @param BookEntity $book
     * @return BookEntity
     * @throws NotFoundRegisterException
     * @throws EntityValidationException
     */
    public function update(BookEntity $book): BookEntity
    {
        $bookDB = $this->bookModel->query()->find($book->id());
        if (!$bookDB) {
            throw new NotFoundRegisterException(message: 'Register not found!');
        }

        $bookDB->query()
            ->update([
                'title' => $book->title,
                'publisher' => $book->publisher,
                'edition' => $book->edition,
                'year' => $book->year,
                'value' => $book->value,
            ]);

        $bookDB->refresh();

        return $this->toBook($bookDB);
    }

    /**
     * Delete one book in database.
     * @param int $id
     * @return bool
     * @throws NotFoundRegisterException
     */
    public function delete(int $id): bool
    {
        $bookDB = $this->bookModel->query()->find($id);
        if (!$bookDB) {
            throw new NotFoundRegisterException(message: 'Register not found!');
        }

        return $bookDB->delete();
    }

    /**
     * Find all books in database.
     * @param string $filter
     * @param string $order
     * @return array
     */
    public function findAll(string $filter = '', string $order = 'DESC'): array
    {
        $books = $this->bookModel
            ->query()
            ->where('title', 'LIKE', "%$filter%")
            ->orderBy('title', $order)
            ->get();

        return $books->toArray();
    }

}
