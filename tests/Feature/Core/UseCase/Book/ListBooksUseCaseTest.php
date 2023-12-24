<?php

namespace Tests\Feature\Core\UseCase\Book;

use Tests\TestCase;
use App\Models\Book;
use App\Repositories\Eloquent\BookEloquentRepository;
use Core\UseCase\Book\ListBooksUseCase;
use Core\UseCase\DTO\Book\Input\RequestListBooksDTO;

class ListBooksUseCaseTest extends TestCase
{
    /**
     * Test to list books use case.
     */
    public function testListBooksUseCase()
    {
        $bookRepository = new BookEloquentRepository(new Book());

        Book::factory()->count(100)->create();
        $useCase = new ListBooksUseCase($bookRepository);

        $response = $useCase->execute(
            inputs: new RequestListBooksDTO(filter: ''),
        );

        $this->assertCount(15, $response->items);
        $this->assertEquals(100, $response->total);
    }
}
