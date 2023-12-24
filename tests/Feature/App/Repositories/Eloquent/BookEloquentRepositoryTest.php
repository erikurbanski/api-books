<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use Throwable;
use Tests\TestCase;

use App\Models\Author;
use App\Models\Book as BookModel;
use App\Repositories\Eloquent\BookEloquentRepository;

use Core\Domain\Entity\Book as BookEntity;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Exception\NotFoundRegisterException;

class BookEloquentRepositoryTest extends TestCase
{
    protected BookEloquentRepository $repository;

    /**
     * Constructor of tests.
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new BookEloquentRepository(new BookModel());
    }

    /**
     * Check interface implements.
     * @return void
     */
    public function testImplementsInterface()
    {
        $this->assertInstanceOf(BookEloquentRepository::class, $this->repository);
    }

    /**
     * Test update to book in database.
     * @return void
     * @throws EntityValidationException
     * @throws NotFoundRegisterException
     */
    public function testUpdate()
    {
        $bookInDB = BookModel::factory()->create();
        $authors = Author::factory()->count(4)->create();

        $updatedBookTitle = 'Updated Title Book';
        $book = new BookEntity(
            title: $updatedBookTitle,
            publisher: 'Atlas Update',
            edition: 4,
            year: '2021',
            value: 190.9,
            id: $bookInDB->id,
        );

        foreach ($authors as $author) {
            $book->addAuthor($author->id);
        }

        $response = $this->repository->update($book);

        $this->assertInstanceOf(BookEntity::class, $response);
        $this->assertNotEquals($response->title, $bookInDB->title);
        $this->assertEquals($updatedBookTitle, $response->title);
    }

    /**
     * Test insert with relations.
     * @throws EntityValidationException
     */
    public function testInsertWithRelationship()
    {
        $authors = Author::factory()->count(4)->create();
        $authorsId = $authors->pluck('id')->toArray();

        $book = new BookEntity(
            title: 'World Map 2023',
            publisher: 'Atlas Update',
            edition: 4,
            year: '2021',
            value: 190.9,
            authorsId: $authorsId,
        );

        $response = $this->repository->insert($book);

        $this->assertDatabaseHas('book', ['id' => $response->id()]);
        $this->assertDatabaseCount('author_book', 4);
    }

    /**
     * Test not found book.
     * @return void
     * @throws NotFoundRegisterException
     * @throws EntityValidationException
     */
    public function testNotFoundBook()
    {
        $this->expectException(NotFoundRegisterException::class);
        $this->repository->getById(22);
    }

    /**
     * A basic feature to test insert book in database.
     * @return void
     * @throws EntityValidationException
     */
    public function testInsert()
    {
        $entity = new BookEntity(
            title: 'Finance Future',
            publisher: 'Atlas',
            edition: 2,
            year: '2023',
            value: 100.9
        );

        $response = $this->repository->insert($entity);

        $this->assertInstanceOf(BookRepositoryInterface::class, $this->repository);
        $this->assertInstanceOf(BookEntity::class, $response);

        $this->assertEquals($entity->year, $response->year);
        $this->assertEquals($entity->title, $response->title);

        $this->assertDatabaseHas('book', ['title' => $entity->title]);
    }

    /**
     * Test to get one book in database.
     * @return void
     * @throws NotFoundRegisterException
     * @throws EntityValidationException
     */
    public function testGetById()
    {
        $book = BookModel::factory()->create();

        $response = $this->repository->getById($book->id);

        $this->assertInstanceOf(BookEntity::class, $response);
        $this->assertEquals($book->id, $response->id());
    }

    /**
     * Test to get one book if not exists in database.
     * @return void
     */
    public function testGetByIdNotFound()
    {
        try {
            $this->repository->getById(333);
            $this->fail();
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundRegisterException::class, $th);
        }
    }

    /**
     * Test to find all books in database.
     * @return void
     */
    public function testFindAll()
    {
        BookModel::factory()->count(10)->create();

        $response = $this->repository->findAll();

        $this->assertCount(10, $response);
    }

    /**
     * Test update to books not found in database.
     * @return void
     */
    public function testUpdateAuthorNotFound()
    {
        try {
            $book = new BookEntity(
                title: 'Finance Future 3',
                publisher: 'Atlas',
                edition: 3,
                year: '2023',
                value: 110.9
            );
            $this->repository->update($book);
            $this->assertTrue(true);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundRegisterException::class, $th);
        }
    }

    /**
     * Test delete not found off book in database.
     * @return void
     */
    public function testDeleteNotFound()
    {
        try {
            $bool = $this->repository->delete(1);
            $this->assertTrue($bool);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundRegisterException::class, $th);
        }
    }

    /**
     * Test delete one book in database.
     * @return void
     * @throws NotFoundRegisterException
     */
    public function testDelete()
    {
        $bookInDB = BookModel::factory()->create();

        $response = $this->repository->delete($bookInDB->id);

        $this->assertTrue($response);
    }
}
