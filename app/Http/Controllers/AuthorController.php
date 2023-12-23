<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Resources\AuthorResource;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;

use Core\UseCase\Author\GetAuthorUseCase;
use Core\UseCase\Author\ListAuthorsUseCase;
use Core\UseCase\Author\CreateAuthorUseCase;
use Core\UseCase\Author\UpdateAuthorUseCase;
use Core\UseCase\Author\DeleteAuthorUseCase;
use Core\Domain\Exception\EntityValidationException;
use Core\UseCase\DTO\Author\Input\RequestGetAuthorDTO;
use Core\UseCase\DTO\Author\Input\RequestListAuthorsDTO;
use Core\UseCase\DTO\Author\Input\RequestCreateAuthorDTO;
use Core\UseCase\DTO\Author\Input\RequestUpdateAuthorDTO;

class AuthorController extends Controller
{
    /**
     * Default action.
     * @param Request $request
     * @param ListAuthorsUseCase $useCase
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, ListAuthorsUseCase $useCase)
    {
        $response = $useCase->execute(
            inputs: new RequestListAuthorsDTO(
                filter: $request->get('filter', ''),
                order: $request->get('order', 'DESC'),
                page: (int) $request->get('page', 1),
                totalPerPage: (int) $request->get('total_page', 15),
            ),
        );

        return AuthorResource::collection(
            collect($response->items)
        )->additional([
            'meta' => [
                'total' => $response->total,
                'last_page' => $response->last_page,
                'first_page' => $response->first_page,
                'per_page' => $response->per_page,
            ]
        ]);
    }

    /**
     * Store one author.
     * @param StoreAuthorRequest $request
     * @param CreateAuthorUseCase $useCase
     * @throws EntityValidationException
     * @return JsonResponse
     */
    public function store(StoreAuthorRequest $request, CreateAuthorUseCase $useCase): JsonResponse
    {
        $response = $useCase->execute(
            requestAuthorDTO: new RequestCreateAuthorDTO(
                name: $request->name,
            ),
        );

        $resource = new AuthorResource(collect($response));
        return $resource
            ->response()
            ->setStatusCode(code: Response::HTTP_CREATED);
    }

    /**
     * Get one author.
     * @param int $id
     * @param GetAuthorUseCase $useCase
     * @return JsonResponse
     */
    public function show(int $id, GetAuthorUseCase $useCase): JsonResponse
    {
        $author = $useCase->execute(
            new RequestGetAuthorDTO($id),
        );

        $resource = new AuthorResource(collect($author));
        return $resource
            ->response()
            ->setStatusCode(code: Response::HTTP_OK);
    }

    /**
     * Update data author.
     * @param int $id
     * @param UpdateAuthorRequest $request
     * @param UpdateAuthorUseCase $useCase
     * @throws EntityValidationException
     * @return JsonResponse
     */
    public function update(int $id, UpdateAuthorRequest $request, UpdateAuthorUseCase $useCase): JsonResponse
    {
        $response = $useCase->execute(
            new RequestUpdateAuthorDTO(
                id: $id,
                name: $request->name,
            ),
        );

        $resource = new AuthorResource(collect($response));
        return $resource
            ->response()
            ->setStatusCode(code: Response::HTTP_OK);
    }

    /**
     * Delete author.
     * @param int $id
     * @param DeleteAuthorUseCase $useCase
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, DeleteAuthorUseCase $useCase): \Illuminate\Http\Response
    {
        $useCase->execute(new RequestGetAuthorDTO($id));

        return response()->noContent();
    }
}
