<?php

namespace Tests\Unit\UseCase\Author;

use Mockery;
use stdClass;
use PHPUnit\Framework\TestCase;

use Core\Domain\Entity\Author;
use Core\Domain\Repository\AuthorRepositoryInterface;

use Core\UseCase\Author\GetAuthorUseCase;
use Core\UseCase\DTO\Author\Input\RequestGetAuthorDTO;
use Core\UseCase\DTO\Author\Output\ResponseGetAuthorDTO;

class GetAuthorUserCaseUnitTest extends TestCase
{
    /**
     * Test use case to get one author.
     */
    public function testGetAuthor()
    {
        $authorId = 22;

        $this->mockAuthorEntity = Mockery::mock(Author::class, ['Erik Urbanski', $authorId]);

        $this->mockAuthorEntity
            ->shouldReceive('formatCreatedAt')
            ->andReturn();

        $this->mockAuthorRepository = Mockery::mock(stdClass::class, AuthorRepositoryInterface::class);
        $this->mockAuthorRepository
            ->shouldReceive('getById')
            ->once()
            ->with($authorId)
            ->andReturn($this->mockAuthorEntity);

        $this->mockRequestGetAuthorDTO = Mockery::mock(RequestGetAuthorDTO::class, [$authorId]);

        $authorUseCase = new GetAuthorUseCase($this->mockAuthorRepository);
        $responseUseCase = $authorUseCase->execute($this->mockRequestGetAuthorDTO);

        $this->assertInstanceOf(ResponseGetAuthorDTO::class, $responseUseCase);
        $this->assertEquals($authorId, $responseUseCase->id);
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