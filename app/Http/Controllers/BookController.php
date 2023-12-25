<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Resources\BookResource;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookPaginatorResource;

use Core\UseCase\Book\GetBookUseCase;
use Core\UseCase\Book\CreateBookUseCase;
use Core\UseCase\Book\DeleteBookUseCase;
use Core\UseCase\Book\ListBooksUseCase;
use Core\UseCase\Book\UpdateBookUseCase;
use Core\UseCase\DTO\Book\Input\RequestGetBookDTO;
use Core\UseCase\DTO\Book\Input\RequestListBooksDTO;
use Core\UseCase\DTO\Book\Input\RequestUpdateBookDTO;
use Core\UseCase\DTO\Book\Input\RequestCreateBookDTO;
use Core\Domain\Exception\EntityValidationException;

class BookController extends Controller
{
    /**
     * Default index action.
     * @param Request $request
     * @param ListBooksUseCase $useCase
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, ListBooksUseCase $useCase)
    {
        $response = $useCase->execute(
            inputs: new RequestListBooksDTO(
                filter: $request->get('filter', ''),
                order: $request->get('order', 'DESC'),
                page: (int) $request->get('page', 1),
                totalPerPage: (int) $request->get('total_page', 15),
            ),
        );

        return BookPaginatorResource::collection(
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
     * Store one book.
     * @param StoreBookRequest $request
     * @param CreateBookUseCase $useCase
     * @return JsonResponse
     * @throws EntityValidationException
     * @throws Throwable
     */
    public function store(StoreBookRequest $request, CreateBookUseCase $useCase): JsonResponse
    {
        $response = $useCase->execute(
            inputs: new RequestCreateBookDTO(
                title: $request->title,
                publisher: $request->publisher,
                edition: $request->edition,
                year: $request->year,
                value: $request->value,
                authorsId: $request->authors ?? [],
                subjectsId: $request->subjects ?? [],
            ),
        );

        $resource = new BookResource($response);
        return $resource
            ->response()
            ->setStatusCode(code: Response::HTTP_CREATED);
    }

    /**
     * Get one book.
     * @param int $id
     * @param GetBookUseCase $useCase
     * @return JsonResponse
     */
    public function show(int $id, GetBookUseCase $useCase): JsonResponse
    {
        $response = $useCase->execute(
            new RequestGetBookDTO($id),
        );

        $resource = new BookResource($response);
        return $resource
            ->response()
            ->setStatusCode(code: Response::HTTP_OK);
    }

    /**
     * Update data book.
     * @param int $id
     * @param UpdateBookRequest $request
     * @param UpdateBookUseCase $useCase
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(int $id, UpdateBookRequest $request, UpdateBookUseCase $useCase): JsonResponse
    {
        $response = $useCase->execute(
            new RequestUpdateBookDTO(
                id: $id,
                title: $request->title,
                publisher: $request->publisher,
                edition: $request->edition,
                year: $request->year,
                value: $request->value,
                authorsId: $request->authors ?? [],
                subjectsId: $request->subjects ?? [],
            ),
        );

        $resource = new BookResource($response);
        return $resource
            ->response()
            ->setStatusCode(code: Response::HTTP_OK);
    }

    /**
     * Delete book.
     * @param int $id
     * @param DeleteBookUseCase $useCase
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, DeleteBookUseCase $useCase): \Illuminate\Http\Response
    {
        $useCase->execute(new RequestGetBookDTO($id));

        return response()->noContent();
    }
}
