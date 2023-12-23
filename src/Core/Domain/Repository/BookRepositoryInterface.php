<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Book;

interface BookRepositoryInterface
{
    public function getById(int $id): Book;

    public function insert(Book $author): Book;

    public function update(Book $author): Book;

    public function delete(int $id): bool;

    public function findAll(string $filter = '', string $order = 'DESC'): array;
}
