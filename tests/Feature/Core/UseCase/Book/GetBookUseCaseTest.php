<?php

namespace Tests\Feature\Core\UseCase\Book;

use Tests\TestCase;
use App\Models\Book;
use App\Repositories\Eloquent\BookEloquentRepository;
use Core\UseCase\Book\GetBookUseCase;
use Core\UseCase\DTO\Book\Input\RequestGetBookDTO;

class GetBookUseCaseTest extends TestCase
{
    /**
     * Test to get one book use case.
     */
    public function testGetBookUseCase()
    {
        $bookRepository = new BookEloquentRepository(new Book());

        $book = Book::factory()->create();
        $useCase = new GetBookUseCase($bookRepository);

        $response = $useCase->execute(
            new RequestGetBookDTO(
                id: $book->id,
            ),
        );

        $this->assertEquals($book->id, $response->id);
        $this->assertEquals($book->title, $response->title);
    }
}
