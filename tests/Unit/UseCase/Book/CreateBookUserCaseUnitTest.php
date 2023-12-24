<?php

namespace Tests\Unit\UseCase\Book;

use Mockery;
use stdClass;
use Throwable;
use PHPUnit\Framework\TestCase;

use Core\Domain\Entity\Book;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Exception\NotFoundRegisterException;

use Core\UseCase\Book\CreateBookUseCase;
use Core\UseCase\Interfaces\TransactionInterface;
use Core\UseCase\DTO\Book\Input\RequestCreateBookDTO;
use Core\UseCase\DTO\Book\Output\ResponseCreateBookDTO;
use Core\Domain\Repository\AuthorRepositoryInterface;

class CreateBookUserCaseUnitTest extends TestCase
{
    /**
     * Test use case to create a new book.
     * @throws EntityValidationException
     * @throws Throwable
     */
    public function testCreateBook()
    {
        $id = 1;
        $bookUseCase = new CreateBookUseCase(
            bookRepository: $this->getMockRepository($id),
            authorRepository: $this->getMockAuthorRepository($id),
            transaction: $this->getMockTransaction(),
        );

        $response = $bookUseCase->execute($this->getMockRequestCreateBookDTO([$id]));

        $this->assertInstanceOf(ResponseCreateBookDTO::class, $response);
    }

    /**
     * Test use case to create a new book if not found authors.
     * @throws Throwable
     * @throws EntityValidationException
     */
    public function testCreateBookIfNotFoundAuthors()
    {
        $this->expectException(NotFoundRegisterException::class);

        $id = 1;
        $mockBookRepository = $this->getMockRepository($id, 0);
        $bookUseCase = new CreateBookUseCase(
            bookRepository: $mockBookRepository,
            authorRepository: $this->getMockAuthorRepository($id),
            transaction: $this->getMockTransaction(),
        );

        $bookUseCase->execute($this->getMockRequestCreateBookDTO([$id, 'fake_value']));
    }

    /**
     * Get mock book entity.
     */
    protected function getMockEntity(int $id)
    {
        $mockBookEntity = Mockery::mock(Book::class, [
            'Design Patterns', 'Atlas', 2, '2023', 58.98, '2023-12-23', '2023-12-23', null, []
        ]);

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
        $mockBookRepository = Mockery::mock(stdClass::class, BookRepositoryInterface::class);
        $mockBookRepository
            ->shouldReceive('insert')
            ->times($timesCalled)
            ->andReturn($this->getMockEntity($id));

        return $mockBookRepository;
    }

    /**
     * Get mock request create DTO.
     */
    protected function getMockRequestCreateBookDTO(array $authorsId)
    {
        return Mockery::mock(RequestCreateBookDTO::class, [
            'Design Patterns', 'Atlas', 2, '2023', 58.98, $authorsId
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
