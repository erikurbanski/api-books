<?php

namespace Tests\Feature\Core\UseCase\Book;

use Tests\TestCase;
use App\Models\Book;
use App\Repositories\Eloquent\BookEloquentRepository;
use Core\UseCase\Book\DeleteBookUseCase;
use Core\UseCase\DTO\Book\Input\RequestGetBookDTO;

class DeleteBookUseCaseTest extends TestCase
{
    /**
     * Test delete author use case with repository, model and entity.
     */
    public function testDeleteBookUseCase()
    {
        $bookDB = Book::factory()->create();
        $repository = new BookEloquentRepository(new Book());

        $useCase = new DeleteBookUseCase($repository);
        $useCase->execute(
            new RequestGetBookDTO(id: $bookDB->id)
        );

        $this->assertDatabaseMissing('book', [
            'title' => $bookDB->title,
        ]);
    }
}
