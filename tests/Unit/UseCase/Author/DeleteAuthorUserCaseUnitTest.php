<?php

namespace Tests\Unit\UseCase\Author;


use Mockery;
use stdClass;
use PHPUnit\Framework\TestCase;

use Core\Domain\Repository\AuthorRepositoryInterface;

use Core\UseCase\Author\DeleteAuthorUseCase;
use Core\UseCase\DTO\Author\Input\RequestGetAuthorDTO;
use Core\UseCase\DTO\Author\Output\ResponseDeleteAuthorDTO;

class DeleteAuthorUserCaseUnitTest extends TestCase
{
    /**
     * Test use case to delete author.
     */
    public function testDeleteAuthor()
    {
        $this->mockAuthorRepository = Mockery::mock(stdClass::class, AuthorRepositoryInterface::class);
        $this->mockAuthorRepository
            ->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $authorId = 22;
        $this->mockRequestGetAuthorDTO = Mockery::mock(RequestGetAuthorDTO::class, [$authorId]);

        $deleteUseCase = new DeleteAuthorUseCase($this->mockAuthorRepository);
        $responseUseCase = $deleteUseCase->execute($this->mockRequestGetAuthorDTO);

        $this->assertInstanceOf(ResponseDeleteAuthorDTO::class, $responseUseCase);
        $this->assertTrue($responseUseCase->success);
    }

    /**
     * Test use case to note delete one author.
     */
    public function testNotDeleteAuthor()
    {
        $this->mockAuthorRepository = Mockery::mock(stdClass::class, AuthorRepositoryInterface::class);
        $this->mockAuthorRepository
            ->shouldReceive('delete')
            ->once()
            ->andReturn(false);

        $authorId = 40;
        $this->mockRequestGetAuthorDTO = Mockery::mock(RequestGetAuthorDTO::class, [$authorId]);

        $deleteUseCase = new DeleteAuthorUseCase($this->mockAuthorRepository);
        $responseUseCase = $deleteUseCase->execute($this->mockRequestGetAuthorDTO);

        $this->assertInstanceOf(ResponseDeleteAuthorDTO::class, $responseUseCase);
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