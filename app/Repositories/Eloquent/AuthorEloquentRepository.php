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
     */
    public function update(AuthorEntity $author): AuthorEntity
    {
        return new AuthorEntity(
            name: 'Teste de Retorno'
        );
    }

    /**
     * Delete one author in database.
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return true;
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
    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $totalPerPage = 15): PaginationInterface
    {
        return new PaginatorPresenter();
    }
}
