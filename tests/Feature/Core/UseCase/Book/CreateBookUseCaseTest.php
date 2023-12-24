<?php

namespace Tests\Feature\Core\UseCase\Book;

use Throwable;
use Tests\TestCase;

use App\Models\Book;
use App\Models\Author;
use App\Repositories\Eloquent\BookEloquentRepository;
use App\Repositories\Transaction\DatabaseTransaction;
use App\Repositories\Eloquent\AuthorEloquentRepository;

use Core\UseCase\Book\CreateBookUseCase;
use Core\UseCase\DTO\Book\Input\RequestCreateBookDTO;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Exception\NotFoundRegisterException;

class CreateBookUseCaseTest extends TestCase
{
    /**
     * Test create book use case with repository, model and entity.
     * @throws EntityValidationException
     * @throws Throwable
     */
    public function testCreateBookUseCase()
    {
        $bookRepository = new BookEloquentRepository(new Book());
        $authorRepository = new AuthorEloquentRepository(new Author());

        $databaseTransaction = new DatabaseTransaction();
        $useCase = new CreateBookUseCase(
            bookRepository: $bookRepository,
            authorRepository: $authorRepository,
            transaction: $databaseTransaction,
        );

        $authors = Author::factory()->count(5)->create();
        $authorsId = $authors->pluck('id')->toArray();

        $response = $useCase->execute(
            inputs: new RequestCreateBookDTO(
                title: 'SOLID e TDD',
                publisher: 'Atlas Update',
                edition: 4,
                year: '2021',
                value: 190.9,
                authorsId: $authorsId,
            ),
        );

        $this->assertEquals('SOLID e TDD', $response->title);
        $this->assertNotEmpty($response->id);

        $this->assertDatabaseHas('book', ['id' => $response->id]);
        $this->assertDatabaseCount('author_book', 5);
    }

    /**
     * Test create book with not exists authors.
     * @throws EntityValidationException
     * @throws Throwable
     */
    public function testCreateBookWithAuthorsDoesNoExistUseCase()
    {
        $this->expectException(NotFoundRegisterException::class);

        $bookRepository = new BookEloquentRepository(new Book());
        $authorRepository = new AuthorEloquentRepository(new Author());

        $databaseTransaction = new DatabaseTransaction();
        $useCase = new CreateBookUseCase(
            bookRepository: $bookRepository,
            authorRepository: $authorRepository,
            transaction: $databaseTransaction,
        );

        $authors = Author::factory()->count(5)->create();
        $authorsId = $authors->pluck('id')->toArray();
        $authorsId[] = 6;

        $useCase->execute(
            inputs: new RequestCreateBookDTO(
                title: 'SOLID e TDD',
                publisher: 'Atlas Update',
                edition: 4,
                year: '2021',
                value: 190.9,
                authorsId: $authorsId,
            ),
        );
    }

    /**
     * Test transaction.
     * @return void
     */
    public function testTransactionInsert()
    {
        $bookRepository = new BookEloquentRepository(new Book());
        $authorRepository = new AuthorEloquentRepository(new Author());

        $databaseTransaction = new DatabaseTransaction();
        $useCase = new CreateBookUseCase(
            bookRepository: $bookRepository,
            authorRepository: $authorRepository,
            transaction: $databaseTransaction,
        );

        $authors = Author::factory()->count(5)->create();
        $authorsId = $authors->pluck('id')->toArray();

        try {
            $useCase->execute(
                inputs: new RequestCreateBookDTO(
                    title: 'SOLID e TDD',
                    publisher: 'Atlas Update',
                    edition: 4,
                    year: '2021',
                    value: 190.9,
                    authorsId: $authorsId,
                ),
            );

            $this->assertDatabaseCount('author_book', 5);
            $this->assertDatabaseHas('book', [
                'title' => 'SOLID e TDD',
            ]);

        } catch (Throwable $th) {
            $this->assertDatabaseCount('book', 0);
            $this->assertDatabaseCount('author_book', 0);
        }
    }
}
