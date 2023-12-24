<?php

namespace Tests\Unit\UseCase\Book;

use Mockery;
use stdClass;
use Throwable;
use PHPUnit\Framework\TestCase;

use Core\Domain\Entity\Book;
use Core\Domain\Repository\BookRepositoryInterface;

use Core\UseCase\Book\UpdateBookUseCase;
use Core\UseCase\Interfaces\TransactionInterface;
use Core\UseCase\DTO\Book\Input\RequestUpdateBookDTO;
use Core\UseCase\DTO\Book\Output\ResponseUpdateBookDTO;
use Core\Domain\Exception\NotFoundRegisterException;
use Core\Domain\Repository\AuthorRepositoryInterface;

class UpdateBookUserCaseUnitTest extends TestCase
{
    /**
     * Test use case to update book.
     * @throws Throwable
     */
    public function testUpdateBook()
    {
        $id = 1;
        $bookUseCase = new UpdateBookUseCase(
            bookRepository: $this->getMockRepository($id),
            authorRepository: $this->getMockAuthorRepository($id),
            transaction: $this->getMockTransaction(),
        );

        $response = $bookUseCase->execute($this->getMockRequestUpdateBookDTO([$id]));

        $this->assertInstanceOf(ResponseUpdateBookDTO::class, $response);
    }

    /**
     * Test use case to update book if not found authors.
     * @throws Throwable
     */
    public function testUpdateBookIfNotFoundAuthors()
    {
        $this->expectException(NotFoundRegisterException::class);

        $id = 1;
        $mockBookRepository = $this->getMockRepository($id, 0);
        $bookUseCase = new UpdateBookUseCase(
            bookRepository: $mockBookRepository,
            authorRepository: $this->getMockAuthorRepository($id),
            transaction: $this->getMockTransaction(),
        );

        $bookUseCase->execute($this->getMockRequestUpdateBookDTO([$id, 2]));
    }

    /**
     * Get mock book entity.
     */
    protected function getMockEntity(int $id)
    {
        $mockBookEntity = Mockery::mock(Book::class, [
            'Design Patterns', 'Atlas', 2, '2023', 58.98, '2023-12-23', '2023-12-23', $id, []
        ]);

        $mockBookEntity->shouldReceive('update');
        $mockBookEntity->shouldReceive('addAuthor');
        $mockBookEntity
            ->shouldReceive('formatCreatedAt')
            ->andReturn();
        $mockBookEntity
            ->shouldReceive('formatUpdatedAt')
            ->andReturn();

        return $mockBookEntity;
    }

    /**
     * Get mock repository book entity.
     */
    protected function getMockRepository(int $id, int $timesCalled = 1)
    {
        $mockBookEntity = $this->getMockEntity($id);

        $mockBookRepository = Mockery::mock(stdClass::class, BookRepositoryInterface::class);
        $mockBookRepository
            ->shouldReceive('getById')
            ->with($id)
            ->once()
            ->andReturn($mockBookEntity);

        $mockBookRepository
            ->shouldReceive('update')
            ->times($timesCalled)
            ->andReturn($mockBookEntity);

        return $mockBookRepository;
    }

    /**
     * Get mock request create DTO.
     */
    protected function getMockRequestUpdateBookDTO(array $authorsId)
    {
        return Mockery::mock(RequestUpdateBookDTO::class, [
            1, 'Design Patterns', 'Atlas', 2, '2023', 58.98, $authorsId
        ]);
    }

    /**
     * Get mock repository author entity.
     */
    protected function getMockAuthorRepository(int $id)
    {
        $mockAuthorRepository = Mockery::mock(stdClass::class, AuthorRepositoryInterface::class);
        $mockAuthorRepository
            ->shouldReceive('getIdsFromListIds')
            ->once()
            ->andReturn([$id]);

        return $mockAuthorRepository;
    }

    /**
     * Get mock transaction.
     */
    protected function getMockTransaction()
    {
        $mockTransaction = Mockery::mock(stdClass::class, TransactionInterface::class);
        $mockTransaction->shouldReceive('commit');
        $mockTransaction->shouldReceive('rollback');

        return $mockTransaction;
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
