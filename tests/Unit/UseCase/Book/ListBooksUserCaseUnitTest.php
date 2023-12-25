<?php

namespace Tests\Unit\UseCase\Book;

use Mockery;
use stdClass;
use DateTime;
use PHPUnit\Framework\TestCase;

use Core\UseCase\Book\ListBooksUseCase;
use Core\Domain\Repository\PaginationInterface;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\UseCase\DTO\Book\Input\RequestListBooksDTO;
use Core\UseCase\DTO\Book\Output\ResponseListBooksDTO;

class ListBooksUserCaseUnitTest extends TestCase
{
    /**
     * Test use case to list books is empty.
     */
    public function testListBooksEmpty()
    {
        $mockPagination = $this->getMockPagination();

        $this->mockBookRepository = Mockery::mock(stdClass::class, BookRepositoryInterface::class);
        $this->mockBookRepository
            ->shouldReceive('paginate')
            ->times(1)
            ->andReturn($mockPagination);

        $this->mockRequestListBooksDTO = Mockery::mock(RequestListBooksDTO::class, ['filter', 'DESC', 1, 15]);

        $listBooksUseCase = new ListBooksUseCase($this->mockBookRepository);
        $responseUseCase = $listBooksUseCase->execute($this->mockRequestListBooksDTO);

        $this->assertCount(0, $responseUseCase->items);
        $this->assertInstanceOf(ResponseListBooksDTO::class, $responseUseCase);

        /**
         * Spies
         * Arrange
         */
        $this->spyBookRepository = Mockery::spy(stdClass::class, BookRepositoryInterface::class);
        $this->spyBookRepository
            ->shouldReceive('paginate')
            ->once()
            ->andReturn($mockPagination);

        # Action
        $listSpyBooksUseCase = new ListBooksUseCase($this->spyBookRepository);
        $listSpyBooksUseCase->execute($this->mockRequestListBooksDTO);

        # Assert
        $this->spyBookRepository
            ->shouldReceive()
            ->paginate('filter', 'ASC', 2, 20);
    }

    /**
     * Test use case to list books.
     */
    public function testListBooks()
    {
        $book1 = new stdClass();
        $book1->id = 1;
        $book1->title = 'Book 1';
        $book1->publisher = 'Publisher 1';
        $book1->year = '2023';
        $book1->value = 20.3;
        $book1->edition = 1;
        $book1->createdAt = new DateTime('now');
        $book1->updatedAt = new DateTime('now');

        $book2 = new stdClass();
        $book2->id = 2;
        $book2->title = 'Book 2';
        $book2->year = '2023';
        $book2->value = 20.3;
        $book2->edition = 2;
        $book2->publisher = 'Publisher 2';
        $book2->createdAt = new DateTime('now');
        $book2->updatedAt = new DateTime('now');

        $mockPagination = $this->getMockPagination([$book1, $book2]);

        $this->mockBookRepository = Mockery::mock(stdClass::class, BookRepositoryInterface::class);
        $this->mockBookRepository
            ->shouldReceive('paginate')
            ->times(1)
            ->andReturn($mockPagination);

        $this->mockRequestListBooksDTO = Mockery::mock(RequestListBooksDTO::class, ['id', 'filter', 1, 15]);

        $listBooksUseCase = new ListBooksUseCase($this->mockBookRepository);
        $responseUseCase = $listBooksUseCase->execute($this->mockRequestListBooksDTO);

        $this->assertCount(2, $responseUseCase->items);
        $this->assertInstanceOf(stdClass::class, $responseUseCase->items[0]);
        $this->assertInstanceOf(ResponseListBooksDTO::class, $responseUseCase);
    }

    /**
     * Get mock pagination config.
     * @param array $items
     * @return mixed
     */
    protected function getMockPagination(array $items = []): mixed
    {
        $mockPagination = Mockery::mock(stdClass::class, PaginationInterface::class);
        $mockPagination
            ->shouldReceive('items')
            ->andReturn($items);

        $mockPagination->shouldReceive('to')->andReturn(0);
        $mockPagination->shouldReceive('from')->andReturn(0);
        $mockPagination->shouldReceive('total')->andReturn(0);
        $mockPagination->shouldReceive('perPage')->andReturn(0);
        $mockPagination->shouldReceive('lastPage')->andReturn(0);
        $mockPagination->shouldReceive('firstPage')->andReturn(0);
        $mockPagination->shouldReceive('currentPage')->andReturn(0);

        return $mockPagination;
    }

    /**
     * Close mock connection.
     * @return void
     */
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
