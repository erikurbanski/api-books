<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Resources\SubjectResource;
use App\Http\Requests\UpdateSubjectRequest;
use App\Http\Requests\StoreSubjectRequest;

use Core\UseCase\Subject\GetSubjectUseCase;
use Core\UseCase\Subject\ListSubjectsUseCase;
use Core\UseCase\Subject\UpdateSubjectUseCase;
use Core\UseCase\Subject\CreateSubjectUseCase;
use Core\UseCase\Subject\DeleteSubjectUseCase;
use Core\Domain\Exception\EntityValidationException;
use Core\UseCase\DTO\Subject\Input\RequestGetSubjectDTO;
use Core\UseCase\DTO\Subject\Input\RequestListSubjectsDTO;
use Core\UseCase\DTO\Subject\Input\RequestUpdateSubjectDTO;
use Core\UseCase\DTO\Subject\Input\RequestCreateSubjectDTO;

class SubjectController extends Controller
{
    /**
     * Default action.
     * @param Request $request
     * @param ListSubjectsUseCase $useCase
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, ListSubjectsUseCase $useCase)
    {
        $response = $useCase->execute(
            inputs: new RequestListSubjectsDTO(
                filter: $request->get('filter', ''),
                order: $request->get('order', 'DESC'),
                page: (int) $request->get('page', 1),
                totalPerPage: (int) $request->get('total_page', 15),
            ),
        );

        return SubjectResource::collection(
            collect($response->items)
        )->additional([
            'meta' => [
                'total' => $response->total,
                'per_page' => $response->per_page,
                'last_page' => $response->last_page,
                'first_page' => $response->first_page,
                'current_page' => $response->current_page,
                'to' => $response->to,
                'from' => $response->from,
            ],
        ]);
    }

    /**
     * Store one subject.
     * @param StoreSubjectRequest $request
     * @param CreateSubjectUseCase $useCase
     * @throws EntityValidationException
     * @return JsonResponse
     */
    public function store(StoreSubjectRequest $request, CreateSubjectUseCase $useCase): JsonResponse
    {
        $response = $useCase->execute(
            inputs: new RequestCreateSubjectDTO(
                description: $request->description,
            ),
        );

        $resource = new SubjectResource($response);
        return $resource
            ->response()
            ->setStatusCode(code: Response::HTTP_CREATED);
    }

    /**
     * Get one subject.
     * @param int $id
     * @param GetSubjectUseCase $useCase
     * @return JsonResponse
     */
    public function show(int $id, GetSubjectUseCase $useCase): JsonResponse
    {
        $subject = $useCase->execute(
            new RequestGetSubjectDTO($id),
        );

        $resource = new SubjectResource($subject);
        return $resource
            ->response()
            ->setStatusCode(code: Response::HTTP_OK);
    }

    /**
     * Update data subject.
     * @param int $id
     * @param UpdateSubjectRequest $request
     * @param UpdateSubjectUseCase $useCase
     * @throws EntityValidationException
     * @return JsonResponse
     */
    public function update(int $id, UpdateSubjectRequest $request, UpdateSubjectUseCase $useCase): JsonResponse
    {
        $response = $useCase->execute(
            new RequestUpdateSubjectDTO(
                id: $id,
                description: $request->description,
            ),
        );

        $resource = new SubjectResource($response);
        return $resource
            ->response()
            ->setStatusCode(code: Response::HTTP_OK);
    }

    /**
     * Delete subject.
     * @param int $id
     * @param DeleteSubjectUseCase $useCase
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, DeleteSubjectUseCase $useCase): \Illuminate\Http\Response
    {
        $useCase->execute(new RequestGetSubjectDTO($id));

        return response()->noContent();
    }
}
