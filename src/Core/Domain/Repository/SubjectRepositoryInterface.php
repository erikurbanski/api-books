<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Subject;

interface SubjectRepositoryInterface
{
    public function getById(int $id): Subject;

    public function insert(Subject $subject): Subject;

    public function update(Subject $subject): Subject;

    public function getIdsFromListIds(array $subjectsId = []): array;

    public function delete(int $id): bool;

    public function findAll(string $filter = '', string $order = 'DESC'): array;

    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $totalPerPage = 15): PaginationInterface;
}
