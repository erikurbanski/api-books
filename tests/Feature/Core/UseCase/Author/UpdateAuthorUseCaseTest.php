<?php

namespace Tests\Feature\Core\UseCase\Author;

use Tests\TestCase;

use App\Models\Author;
use App\Repositories\Eloquent\AuthorEloquentRepository;

use Core\UseCase\Author\UpdateAuthorUseCase;
use Core\Domain\Exception\EntityValidationException;
use Core\UseCase\DTO\Author\Input\RequestUpdateAuthorDTO;

class UpdateAuthorUseCaseTest extends TestCase
{
    /**
     * Test to update author use case.
     * @throws EntityValidationException
     */
    public function testUpdateAuthorUseCase()
    {
        $authorDB = Author::factory()->create();

        $repository = new AuthorEloquentRepository(new Author());
        $useCase = new UpdateAuthorUseCase($repository);

        $responseUseCase = $useCase->execute(
            new RequestUpdateAuthorDTO(
                id: $authorDB->id,
                name: 'Updated Name',
            ),
        );

        $this->assertEquals('Updated Name', $responseUseCase->name);
        $this->assertDatabaseHas('author', [
            'name' => $responseUseCase->name
        ]);
    }
}
