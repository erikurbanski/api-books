<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use Throwable;
use Tests\TestCase;

use App\Models\Author as AuthorModel;
use App\Repositories\Eloquent\AuthorEloquentRepository;

use Core\Domain\Entity\Author as AuthorEntity;
use Core\Domain\Repository\PaginationInterface;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Exception\NotFoundRegisterException;
use Core\Domain\Repository\AuthorRepositoryInterface;

class AuthorEloquentRepositoryUnitTest extends TestCase
{
    protected AuthorEloquentRepository $repository;

    /**
     * Constructor of tests.
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new AuthorEloquentRepository(new AuthorModel());
    }

    /**
     * A basic feature to test insert in database.
     * @return void
     * @throws EntityValidationException
     */
    public function testInsert()
    {
        $entity = new AuthorEntity(name: 'Erik Urbanski');

        $response = $this->repository->insert($entity);

        $this->assertInstanceOf(AuthorRepositoryInterface::class, $this->repository);
        $this->assertInstanceOf(AuthorEntity::class, $response);

        $this->assertDatabaseHas('authors', ['name' => $entity->name]);
    }

    /**
     * Test to get one author in database.
     * @return void
     * @throws NotFoundRegisterException
     * @throws EntityValidationException
     */
    public function testGetById()
    {
        $author = AuthorModel::factory()->create();

        $response = $this->repository->getById($author->id);

        $this->assertInstanceOf(AuthorEntity::class, $response);
        $this->assertEquals($author->id, $response->id());
    }

    /**
     * Test to get one author if not exists in database.
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
     * Test to find all authors in database.
     * @return void
     */
    public function testFindAll()
    {
        AuthorModel::factory()->count(10)->create();

        $response = $this->repository->findAll();

        $this->assertCount(10, $response);
    }

    /**
     * Test paginate authors in database.
     * @return void
     */
    public function testPaginate()
    {
        AuthorModel::factory()->count(45)->create();

        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(15, $response->items());
    }

    /**
     * Test paginate authors in database.
     * @return void
     */
    public function testPaginateEmpty()
    {
        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(0, $response->items());
    }
}
