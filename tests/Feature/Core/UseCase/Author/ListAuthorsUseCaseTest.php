<?php

namespace Tests\Feature\Core\UseCase\Author;

use Tests\TestCase;

use App\Models\Author;
use App\Repositories\Eloquent\AuthorEloquentRepository;

use Core\UseCase\Author\ListAuthorsUseCase;
use Core\UseCase\DTO\Author\Input\RequestListAuthorsDTO;
use Core\UseCase\DTO\Author\Output\ResponseListAuthorsDTO;

class ListAuthorsUseCaseTest extends TestCase
{
    /**
     * Initialize use case.
     * @return ResponseListAuthorsDTO
     */
    protected function initUseCase(): ResponseListAuthorsDTO
    {
        $repository = new AuthorEloquentRepository(new Author());
        $useCase = new ListAuthorsUseCase($repository);
        return $useCase->execute(
            new RequestListAuthorsDTO(
                filter: '',
                order: 'DESC',
            ),
        );
    }

    /**
     * Test to list authors empty use case.
     */
    public function testListAuthorsEmptyUseCase()
    {
        $response = $this->initUseCase();
        $this->assertCount(0, $response->items);
    }

    /**
     * Test to list all authors use case.
     */
    public function testListAuthorsUseCase()
    {
        $authors = Author::factory()->count(20)->create();

        $response = $this->initUseCase();

        $this->assertCount(15, $response->items);
        $this->assertEquals(count($authors), $response->total);
    }
}
