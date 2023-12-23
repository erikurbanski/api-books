<?php

namespace Tests\Unit\UseCase\Book;

use Mockery;
use stdClass;
use PHPUnit\Framework\TestCase;

use Core\Domain\Entity\Book;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\Exception\EntityValidationException;

use Core\UseCase\Book\CreateBookUseCase;
use Core\UseCase\DTO\Book\Input\RequestCreateBookDTO;
use Core\UseCase\DTO\Book\Output\ResponseCreateBookDTO;

class CreateBookUserCaseUnitTest extends TestCase
{
    /**
     * Test use case to create a new book.
     * @throws EntityValidationException
     */
    public function testCreateBook()
    {
        $bookTitle = 'Design Patterns';

        $this->mockBookEntity = Mockery::mock(Book::class, [
            $bookTitle, 'Atlas', 2, '2023', 58.98, '2023-12-23', '2023-12-23',
        ]);

        $this->mockBookEntity
            ->shouldReceive('name')
            ->andReturn($bookTitle);

        $this->mockBookEntity
            ->shouldReceive('formatCreatedAt')
            ->andReturn();

        $this->mockBookEntity
            ->shouldReceive('formatUpdatedAt')
            ->andReturn();

        $this->mockBookRepository = Mockery::mock(stdClass::class, BookRepositoryInterface::class);
        $this->mockBookRepository
            ->shouldReceive('insert')
            ->times(1)
            ->andReturn($this->mockBookEntity);

        $this->mockRequestCreateBookDTO = Mockery::mock(RequestCreateBookDTO::class, [
            $bookTitle, 'Atlas', 2, '2023', 58.98,
        ]);

        $authorUseCase = new CreateBookUseCase($this->mockBookRepository);
        $responseUseCase = $authorUseCase->execute($this->mockRequestCreateBookDTO);

        $this->assertInstanceOf(ResponseCreateBookDTO::class, $responseUseCase);
        $this->assertEquals($bookTitle, $responseUseCase->title);

        Mockery::close();
    }
}
