<?php

namespace Tests\Unit\UseCase\Book;

use Mockery;
use stdClass;
use PHPUnit\Framework\TestCase;

use Core\Domain\Entity\Book;
use Core\Domain\Repository\BookRepositoryInterface;

use Core\UseCase\Book\UpdateBookUseCase;
use Core\UseCase\DTO\Book\Input\RequestUpdateBookDTO;
use Core\UseCase\DTO\Book\Output\ResponseUpdateBookDTO;

class UpdateBookUseCaseUnitTest extends TestCase
{
    /**
     * Test use case to update data from book.
     */
    public function testUpdateBook()
    {
        $bookId = 22;

        $this->mockBookEntity = Mockery::mock(Book::class, [
           'SOLID and TDD', 'Atlas', 2, '2023', 58.98, '2023-12-23', '2023-12-23', $bookId,
        ]);

        $this->mockBookEntity->shouldReceive('update');

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

        $this->mockBookRepository
            ->shouldReceive('update')
            ->once()
            ->andReturn($this->mockBookEntity);

        $bookUpdateName = 'New book about SOLID';
        $this->mockRequestUpdateBookDTO = Mockery::mock(RequestUpdateBookDTO::class, [
            $bookId, $bookUpdateName, 'Pandas', 2, '2023', 99.9
        ]);

        $updateUseCase = new UpdateBookUseCase($this->mockBookRepository);
        $responseUseCase = $updateUseCase->execute($this->mockRequestUpdateBookDTO);

        $this->assertInstanceOf(ResponseUpdateBookDTO::class, $responseUseCase);

        Mockery::close();
    }
}
