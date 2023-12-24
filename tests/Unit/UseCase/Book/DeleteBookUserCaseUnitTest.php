<?php

namespace Tests\Unit\UseCase\Book;

use Mockery;
use stdClass;
use PHPUnit\Framework\TestCase;

use Core\UseCase\Book\DeleteBookUseCase;
use Core\UseCase\DTO\Book\Input\RequestGetBookDTO;
use Core\UseCase\DTO\Book\Output\ResponseDeleteBookDTO;
use Core\Domain\Repository\BookRepositoryInterface;

class DeleteBookUserCaseUnitTest extends TestCase
{
    /**
     * Test use case to delete book.
     */
    public function testDeleteBook()
    {
        # Arrange
        $this->mockBookRepository = Mockery::mock(stdClass::class, BookRepositoryInterface::class);

        # Spec
        $this->mockBookRepository
            ->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $bookId = 1;
        $this->mockRequestGetBookDTO = Mockery::mock(RequestGetBookDTO::class, [$bookId]);

        # Action
        $deleteUseCase = new DeleteBookUseCase($this->mockBookRepository);
        $responseUseCase = $deleteUseCase->execute($this->mockRequestGetBookDTO);

        # Assert
        $this->assertInstanceOf(ResponseDeleteBookDTO::class, $responseUseCase);
        $this->assertTrue($responseUseCase->success);
    }

    /**
     * Test use case to note delete one book.
     */
    public function testNotDeleteBook()
    {
        $bookId = 2;
        $this->mockBookRepository = Mockery::mock(stdClass::class, BookRepositoryInterface::class);
        $this->mockBookRepository
            ->shouldReceive('delete')
            ->times(1)
            ->with($bookId)
            ->andReturn(false);

        $this->mockRequestGetBookDTO = Mockery::mock(RequestGetBookDTO::class, [$bookId]);

        $deleteUseCase = new DeleteBookUseCase($this->mockBookRepository);
        $responseUseCase = $deleteUseCase->execute($this->mockRequestGetBookDTO);

        $this->assertInstanceOf(ResponseDeleteBookDTO::class, $responseUseCase);
        $this->assertFalse($responseUseCase->success);
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
