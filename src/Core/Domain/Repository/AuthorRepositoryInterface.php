<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Author;

interface AuthorRepositoryInterface
{
    public function getById(int $id): Author;

    public function insert(Author $author): Author;

    public function update(Author $author): Author;

    public function getIdsFromListIds(array $authorsId = []): array;

    public function delete(int $id): bool;

    public function findAll(string $filter = '', string $order = 'DESC'): array;

    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $totalPerPage = 15): PaginationInterface;
}
