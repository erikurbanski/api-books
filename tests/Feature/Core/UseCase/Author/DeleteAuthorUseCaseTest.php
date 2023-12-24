<?php

namespace Tests\Feature\Core\UseCase\Author;

use Tests\TestCase;

use App\Models\Author;
use App\Repositories\Eloquent\AuthorEloquentRepository;

use Core\UseCase\Author\DeleteAuthorUseCase;
use Core\UseCase\DTO\Author\Input\RequestGetAuthorDTO;

class DeleteAuthorUseCaseTest extends TestCase
{
    /**
     * Test delete author use case with repository, model and entity.
     */
    public function testDeleteAuthorUseCase()
    {
        $authorDB = Author::factory()->create();
        $repository = new AuthorEloquentRepository(new Author());

        $useCase = new DeleteAuthorUseCase($repository);
        $useCase->execute(
            new RequestGetAuthorDTO(id: $authorDB->id)
        );

        $this->assertDatabaseMissing('author', [
            'name' => $authorDB->name,
        ]);
    }
}
