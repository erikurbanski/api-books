<?php

namespace Tests\Unit\UseCase\Book;

use Mockery;
use stdClass;
use PHPUnit\Framework\TestCase;

use Core\Domain\Entity\Book;
use Core\Domain\Repository\BookRepositoryInterface;

use Core\UseCase\Book\GetBookUseCase;
use Core\UseCase\DTO\Book\Input\RequestGetBookDTO;
use Core\UseCase\DTO\Book\Output\ResponseGetBookDTO;

class GetBookUserCaseUnitTest extends TestCase
{
    /**
     * Test use case to get one book.
     */
    public function testGetBook()
    {
        $bookId = 22;
        $this->mockBookEntity = Mockery::mock(Book::class, [
            'SOLID and TDD in Praticle', 'Atlas', 2, '2023', 58.98, '2023-12-23', '2023-12-23', $bookId,
        ]);

        $this->mockBookEntity
            ->shouldReceive('formatCreatedAt')
            ->andReturn();

        $this->mockBookEntity
            ->shouldReceive('formatUpdatedAt')
            ->andReturn();

        $this->mockBookRepository = Mockery::mock(stdClass::class, BookRepositoryInterface::class);
        $this->mockBookRepository
            ->shouldReceive('getById')
            ->once()
            ->with($bookId)
            ->andReturn($this->mockBookEntity);

        $this->mockRequestGetBookDTO = Mockery::mock(RequestGetBookDTO::class, [$bookId]);

        $bookUseCase = new GetBookUseCase($this->mockBookRepository);
        $responseUseCase = $bookUseCase->execute($this->mockRequestGetBookDTO);

        $this->assertInstanceOf(ResponseGetBookDTO::class, $responseUseCase);
        $this->assertEquals($bookId, $responseUseCase->id);
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
