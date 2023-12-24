<?php

namespace Tests\Feature\Core\UseCase\Author;

use Tests\TestCase;

use App\Models\Author;
use App\Repositories\Eloquent\AuthorEloquentRepository;

use Core\Domain\Exception\EntityValidationException;
use Core\UseCase\Author\CreateAuthorUseCase;
use Core\UseCase\DTO\Author\Input\RequestCreateAuthorDTO;

class CreateAuthorUseCaseTest extends TestCase
{
    /**
     * Test create author use case with repository, model and entity.
     * @throws EntityValidationException
     */
    public function testCreateAuthorUseCase()
    {
        $repository = new AuthorEloquentRepository(new Author());

        $useCase = new CreateAuthorUseCase($repository);
        $response = $useCase->execute(
            new RequestCreateAuthorDTO(
                name: 'Milene Diniz',
            ),
        );

        $this->assertEquals('Milene Diniz', $response->name);
        $this->assertNotEmpty($response->id);

        $this->assertDatabaseHas('author', ['id' => $response->id]);
    }
}
