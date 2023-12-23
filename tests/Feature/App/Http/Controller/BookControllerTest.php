<?php

namespace Tests\Feature\App\Http\Controller;

use Tests\TestCase;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Controllers\BookController;
use App\Repositories\Eloquent\BookEloquentRepository;

use Core\UseCase\Book\GetBookUseCase;
use Core\UseCase\Book\ListBooksUseCase;
use Core\UseCase\Book\UpdateBookUseCase;
use Core\UseCase\Book\CreateBookUseCase;
use Core\UseCase\Book\DeleteBookUseCase;
use Core\Domain\Exception\EntityValidationException;

class BookControllerTest extends TestCase
{
    protected BookController $controller;
    protected BookEloquentRepository $repository;

    /**
     * Initialize config tests.
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new BookController();
        $this->repository = new BookEloquentRepository(new Book());
    }

    /**
     * Test index controller.
     * @return void
     */
    public function testIndex()
    {
        $useCase = new ListBooksUseCase($this->repository);
        $response = $this->controller->index(
            request: new Request(),
            useCase: $useCase,
        );

        $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
        $this->assertArrayHasKey('meta', $response->additional);
    }

    /**
     * Test store controller.
     * @return void
     * @throws EntityValidationException
     */
    public function testStore()
    {
        $useCase = new CreateBookUseCase($this->repository);
        $request = new StoreBookRequest();

        $request->headers->set('content-type', 'application/json');
        $request->setJson(
            new ParameterBag([
                'title' => 'SOLID Principle',
                'publisher' => 'Pandas',
                'edition' => 1,
                'year' => '2023',
                'value' => 100
            ]),
        );

        $response = $this->controller->store($request, $useCase);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
    }

    /**
     * Test show book controller.
     * @return void
     */
    public function testShow()
    {
        $book = Book::factory()->create();

        $response = $this->controller->show(
            id: $book->id,
            useCase: new GetBookUseCase($this->repository),
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
    }

    /**
     * Test update book controller.
     * @return void
     */
    public function testUpdate()
    {
        $book = Book::factory()->create();

        $useCase = new UpdateBookUseCase($this->repository);
        $request = new UpdateBookRequest();

        $request->headers->set('content-type', 'application/json');
        $request->setJson(
            new ParameterBag([
                'name' => 'Update Author Name',
                'title' => 'SOLID e TDD',
                'publisher' => 'Atlas',
                'edition' => 2,
                'year' => '2022',
                'value' => 129.8
            ]),
        );

        $response = $this->controller->update(
            id: $book->id,
            request: $request,
            useCase: $useCase,
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
    }

    /**
     * Test delete book controller.
     * @return void
     */
    public function testDelete()
    {
        $book = Book::factory()->create();

        $response = $this->controller->destroy(
            id: $book->id,
            useCase: new DeleteBookUseCase($this->repository),
        );

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->status());
    }
}
