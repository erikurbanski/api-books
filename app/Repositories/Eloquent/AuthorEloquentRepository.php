<?php

namespace App\Repositories\Eloquent;

use App\Models\Author as AuthorModel;
use App\Repositories\Presenters\PaginatorPresenter;

use Core\Domain\Entity\Author as AuthorEntity;
use Core\Domain\Repository\PaginationInterface;
use Core\Domain\Repository\AuthorRepositoryInterface;
use Core\Domain\Exception\NotFoundRegisterException;
use Core\Domain\Exception\EntityValidationException;

class AuthorEloquentRepository implements AuthorRepositoryInterface
{
    /**
     * Constructor class.
     * @param AuthorModel $authorModel
     */
    public function __construct(
        protected AuthorModel $authorModel
    )
    {
    }

    /**
     * Convert model object in entity.
     * @param object $object
     * @return AuthorEntity
     * @throws EntityValidationException
     */
    private function toAuthor(object $object): AuthorEntity
    {
        return new AuthorEntity(
            name: $object->name,
            id: $object->id
        );
    }

    /**
     * Return one author from database.
     * @param int $id
     * @return AuthorEntity
     * @throws NotFoundRegisterException
     * @throws EntityValidationException
     */
    public function getById(int $id): AuthorEntity
    {
        $author = $this->authorModel->query()->find($id);

        if (!$author) {
            throw new NotFoundRegisterException(message: 'Register not found!');
        }

        return $this->toAuthor($author);
    }

    /**
     * Insert new author in database.
     * @param AuthorEntity $author
     * @return AuthorEntity
     * @throws EntityValidationException
     */
    public function insert(AuthorEntity $author): AuthorEntity
    {
        $author = $this->authorModel->query()->create([
            'name' => $author->name,
        ]);

        return $this->toAuthor($author);
    }

    /**
     * Update one author in database.
     * @param AuthorEntity $author
     * @return AuthorEntity
     * @throws NotFoundRegisterException
     * @throws EntityValidationException
     */
    public function update(AuthorEntity $author): AuthorEntity
    {
        $authorDB = $this->authorModel->query()->find($author->id());
        if (!$authorDB) {
            throw new NotFoundRegisterException(message: 'Register not found!');
        }

        $authorDB->name = $author->name;

        $authorDB->update();
        $authorDB->refresh();

        return $this->toAuthor($authorDB);
    }

    /**
     * Delete one author in database.
     * @param int $id
     * @return bool
     * @throws NotFoundRegisterException
     */
    public function delete(int $id): bool
    {
        $authorDB = $this->authorModel->query()->find($id);
        if (!$authorDB) {
            throw new NotFoundRegisterException(message: 'Register not found!');
        }

        return $authorDB->delete();
    }

    /**
     * Find all authors in database.
     * @param string $filter
     * @param string $order
     * @return array
     */
    public function findAll(string $filter = '', string $order = 'DESC'): array
    {
        $authors = $this->authorModel
            ->query()
            ->where('name', 'LIKE', "%$filter%")
            ->orderBy('name', $order)
            ->get();

        return $authors->toArray();
    }

    /**
     * Paginate register from author.
     * @param string $filter
     * @param string $order
     * @param int $page
     * @param int $totalPerPage
     * @return PaginationInterface
     */
    public function paginate(
        string $filter = '',
        string $order = 'DESC',
        int    $page = 1,
        int    $totalPerPage = 15,
    ): PaginationInterface
    {
        $query = $this->authorModel->query();

        if ($filter) {
            $query->where('name', 'LIKE', "%$filter%");
        }

        $query->orderBy('name', $order);
        $paginator = $query->paginate();

        return new PaginatorPresenter($paginator);
    }

    /**
     * Return a list off id's from list id's.
     * @param array $authorsId
     * @return array
     */
    public function getIdsFromListIds(array $authorsId = []): array
    {
        return $this->authorModel
            ->query()
            ->whereIn('id', $authorsId)
            ->pluck('id')
            ->toArray();
    }
}
