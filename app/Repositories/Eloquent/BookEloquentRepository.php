<?php

namespace App\Repositories\Eloquent;

use App\Models\Book as BookModel;
use Core\Domain\Entity\Book as BookEntity;
use Core\Domain\Repository\PaginationInterface;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\Exception\NotFoundRegisterException;
use Core\Domain\Exception\EntityValidationException;
use App\Repositories\Presenters\PaginatorPresenter;

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
        $authorsId = $object->authors ? $object->authors->pluck('id')->toArray() : [];
        $subjectsId = $object->subjects ? $object->subjects->pluck('id')->toArray() : [];

        return new BookEntity(
            title: $object->title,
            publisher: $object->publisher,
            edition: $object->edition,
            year: $object->year,
            value: $object->value,
            id: $object->id,
            authorsId: $authorsId,
            subjectsId: $subjectsId,
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
        $book = $this->bookModel
            ->query()
            ->with([
                'authors',
                'subjects',
            ])
            ->find($id);

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
        $savedBook = $this->bookModel->query()->create([
            'title' => $book->title,
            'publisher' => $book->publisher,
            'edition' => $book->edition,
            'year' => $book->year,
            'value' => $book->value,
        ]);

        if (count($book->authorsId) > 0) {
            $savedBook->authors()->sync($book->authorsId);
        }

        if (count($book->subjectsId) > 0) {
            $savedBook->subjects()->sync($book->subjectsId);
        }

        return $this->toBook($savedBook);
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

        $bookDB->year = $book->year;
        $bookDB->title = $book->title;
        $bookDB->value = $book->value;
        $bookDB->edition = $book->edition;
        $bookDB->publisher = $book->publisher;

        $bookDB->update();

        if (count($book->authorsId) > 0) {
            $bookDB->authors()->sync($book->authorsId);
        }

        if (count($book->subjectsId) > 0) {
            $bookDB->subjects()->sync($book->subjectsId);
        }

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

    /**
     * Paginate books.
     * @param string $filter
     * @param string $order
     * @param int $page
     * @param int $totalPerPage
     * @return PaginationInterface
     */
    public function paginate(
        string $filter = '',
        string $order = 'DESC',
        int $page = 1,
        int $totalPerPage = 15
    ): PaginationInterface
    {
        $query = $this->bookModel
            ->query()
            ->with([
                'authors',
                'subjects',
            ]);

        if ($filter) {
            $query->where('title', 'LIKE', "%$filter%");
        }

        $query->orderBy('title', $order);
        $paginator = $query->paginate();

        return new PaginatorPresenter($paginator);
    }
}
