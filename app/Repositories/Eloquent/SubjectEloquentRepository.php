<?php

namespace App\Repositories\Eloquent;

use App\Models\Subject as SubjectModel;
use App\Repositories\Presenters\PaginatorPresenter;

use Core\Domain\Entity\Subject as SubjectEntity;
use Core\Domain\Repository\PaginationInterface;
use Core\Domain\Exception\NotFoundRegisterException;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Repository\SubjectRepositoryInterface;

class SubjectEloquentRepository implements SubjectRepositoryInterface
{
    /**
     * Constructor class.
     * @param SubjectModel $subjectModel
     */
    public function __construct(
        protected SubjectModel $subjectModel
    )
    {
    }

    /**
     * Convert model object in entity.
     * @param object $object
     * @return SubjectEntity
     * @throws EntityValidationException
     */
    private function toSubject(object $object): SubjectEntity
    {
        return new SubjectEntity(
            description: $object->description,
            createdAt: $object->created_at,
            updatedAt: $object->updated_at,
            id: $object->id
        );
    }

    /**
     * Return one subject from database.
     * @param int $id
     * @return SubjectEntity
     * @throws NotFoundRegisterException
     * @throws EntityValidationException
     */
    public function getById(int $id): SubjectEntity
    {
        $subject = $this->subjectModel->query()->find($id);

        if (!$subject) {
            throw new NotFoundRegisterException(message: 'Register not found!');
        }

        return $this->toSubject($subject);
    }

    /**
     * Insert new subject in database.
     * @param SubjectEntity $subject
     * @return SubjectEntity
     * @throws EntityValidationException
     */
    public function insert(SubjectEntity $subject): SubjectEntity
    {
        $subject = $this->subjectModel->query()->create([
            'description' => $subject->description,
        ]);

        return $this->toSubject($subject);
    }

    /**
     * Update one subject in database.
     * @param SubjectEntity $subject
     * @return SubjectEntity
     * @throws NotFoundRegisterException
     * @throws EntityValidationException
     */
    public function update(SubjectEntity $subject): SubjectEntity
    {
        $subjectDB = $this->subjectModel->query()->find($subject->id());
        if (!$subjectDB) {
            throw new NotFoundRegisterException(message: 'Register not found!');
        }

        $subjectDB->description = $subject->description;

        $subjectDB->update();
        $subjectDB->refresh();

        return $this->toSubject($subjectDB);
    }

    /**
     * Delete one subject in database.
     * @param int $id
     * @return bool
     * @throws NotFoundRegisterException
     */
    public function delete(int $id): bool
    {
        $subjectDB = $this->subjectModel->query()->find($id);
        if (!$subjectDB) {
            throw new NotFoundRegisterException(message: 'Register not found!');
        }

        return $subjectDB->delete();
    }

    /**
     * Find all subjects in database.
     * @param string $filter
     * @param string $order
     * @return array
     */
    public function findAll(string $filter = '', string $order = 'DESC'): array
    {
        $subjects = $this->subjectModel
            ->query()
            ->where('description', 'LIKE', "%$filter%")
            ->orderBy('description', $order)
            ->get();

        return $subjects->toArray();
    }

    /**
     * Paginate register from subject.
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
        $query = $this->subjectModel->query();

        if ($filter) {
            $query->where('description', 'LIKE', "%$filter%");
        }

        $query->orderBy('description', $order);
        $paginator = $query->paginate();

        return new PaginatorPresenter($paginator);
    }

    /**
     * Return a list off id's from list id's.
     * @param array $subjectsId
     * @return array
     */
    public function getIdsFromListIds(array $subjectsId = []): array
    {
        return $this->subjectModel
            ->query()
            ->whereIn('id', $subjectsId)
            ->pluck('id')
            ->toArray();
    }
}
