<?php

namespace Tests\Unit\UseCase\Author;

use Mockery;
use stdClass;
use DateTime;
use PHPUnit\Framework\TestCase;

use Core\Domain\Repository\PaginationInterface;
use Core\Domain\Repository\AuthorRepositoryInterface;

use Core\UseCase\Author\ListAuthorsUseCase;
use Core\UseCase\DTO\Author\Input\RequestListAuthorsDTO;
use Core\UseCase\DTO\Author\Output\ResponseListAuthorsDTO;

class ListAuthorsUserCaseUnitTest extends TestCase
{
    /**
     * Test use case to list authors is empty.
     */
    public function testListAuthorsEmpty()
    {
        $mockPagination = $this->getMockPagination();

        $this->mockAuthorRepository = Mockery::mock(stdClass::class, AuthorRepositoryInterface::class);
        $this->mockAuthorRepository
            ->shouldReceive('paginate')
            ->times(1)
            ->andReturn($mockPagination);

        $this->mockRequestListAuthorsDTO = Mockery::mock(RequestListAuthorsDTO::class, ['id', 'filter', 1, 15]);

        $listAuthorsUseCase = new ListAuthorsUseCase($this->mockAuthorRepository);
        $responseUseCase = $listAuthorsUseCase->execute($this->mockRequestListAuthorsDTO);

        $this->assertCount(0, $responseUseCase->items);
        $this->assertInstanceOf(ResponseListAuthorsDTO::class, $responseUseCase);
    }

    /**
     * Test use case to list authors.
     */
    public function testListAuthors()
    {
        $author1 = new stdClass();
        $author1->id = 1;
        $author1->name = 'Erik Urbanski Santos';
        $author1->createdAt = new DateTime('now');

        $author2 = new stdClass();
        $author2->id = 2;
        $author2->name = 'Milene Diniz';
        $author2->createdAt = new DateTime('now');

        $mockPagination = $this->getMockPagination([$author1, $author2]);

        $this->mockAuthorRepository = Mockery::mock(stdClass::class, AuthorRepositoryInterface::class);
        $this->mockAuthorRepository
            ->shouldReceive('paginate')
            ->times(1)
            ->andReturn($mockPagination);

        $this->mockRequestListAuthorsDTO = Mockery::mock(RequestListAuthorsDTO::class, ['id', 'filter', 1, 15]);

        $listAuthorsUseCase = new ListAuthorsUseCase($this->mockAuthorRepository);
        $responseUseCase = $listAuthorsUseCase->execute($this->mockRequestListAuthorsDTO);

        $this->assertCount(2, $responseUseCase->items);
        $this->assertInstanceOf(stdClass::class, $responseUseCase->items[0]);
        $this->assertInstanceOf(ResponseListAuthorsDTO::class, $responseUseCase);
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
