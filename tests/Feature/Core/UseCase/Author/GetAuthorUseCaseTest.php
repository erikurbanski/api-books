<?php

namespace Tests\Feature\Core\UseCase\Author;

use Tests\TestCase;

use App\Models\Author;
use App\Repositories\Eloquent\AuthorEloquentRepository;

use Core\UseCase\Author\GetAuthorUseCase;
use Core\UseCase\DTO\Author\Input\RequestGetAuthorDTO;

class GetAuthorUseCaseTest extends TestCase
{
    /**
     * Test to get one author use case.
     */
    public function testGetAuthorUseCase()
    {
        $authorDB = Author::factory()->create();

        $repository = new AuthorEloquentRepository(new Author());

        $useCase = new GetAuthorUseCase($repository);
        $response = $useCase->execute(
            new RequestGetAuthorDTO(
                id: $authorDB->id
            ),
        );

        $this->assertEquals($authorDB->id, $response->id);
        $this->assertEquals($authorDB->name, $response->name);
    }
}
