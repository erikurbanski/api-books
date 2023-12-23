<?php

namespace Tests\Feature\App\Http\Controller;

use Core\UseCase\Author\DeleteAuthorUseCase;
use Tests\TestCase;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use Core\UseCase\Author\GetAuthorUseCase;
use Core\UseCase\Author\ListAuthorsUseCase;
use Core\UseCase\Author\CreateAuthorUseCase;
use Core\UseCase\Author\UpdateAuthorUseCase;
use Core\Domain\Exception\EntityValidationException;

use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Controllers\AuthorController;
use App\Repositories\Eloquent\AuthorEloquentRepository;

class AuthorControllerTest extends TestCase
{
    protected AuthorController $controller;
    protected AuthorEloquentRepository $repository;

    /**
     * Initialize config tests.
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new AuthorController();
        $this->repository = new AuthorEloquentRepository(new Author());
    }

    /**
     * Test index controller.
     * @return void
     */
    public function testIndex()
    {
        $useCase = new ListAuthorsUseCase($this->repository);
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
        $useCase = new CreateAuthorUseCase($this->repository);
        $request = new StoreAuthorRequest();

        $request->headers->set('content-type', 'application/json');
        $request->setJson(
            new ParameterBag([
                'name' => 'Erik Urbanski Santos',
            ]),
        );

        $response = $this->controller->store($request, $useCase);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
    }

    /**
     * Test show author controller.
     * @return void
     */
    public function testShow()
    {
        $author = Author::factory()->create();

        $response = $this->controller->show(
            id: $author->id,
            useCase: new GetAuthorUseCase($this->repository),
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
    }

    /**
     * Test update author controller.
     * @return void
     * @throws EntityValidationException
     */
    public function testUpdate()
    {
        $author = Author::factory()->create();

        $useCase = new UpdateAuthorUseCase($this->repository);
        $request = new UpdateAuthorRequest();

        $request->headers->set('content-type', 'application/json');
        $request->setJson(
            new ParameterBag([
                'name' => 'Update Author Name',
            ]),
        );

        $response = $this->controller->update(
            id: $author->id,
            request: $request,
            useCase: $useCase,
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
    }

    /**
     * Test delete author controller.
     * @return void
     */
    public function testDelete()
    {
        $author = Author::factory()->create();

        $response = $this->controller->destroy(
            id: $author->id,
            useCase: new DeleteAuthorUseCase($this->repository),
        );

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->status());
    }
}
