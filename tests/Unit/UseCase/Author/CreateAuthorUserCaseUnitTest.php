<?php

namespace Tests\Unit\UseCase\Author;

use Mockery;
use stdClass;
use PHPUnit\Framework\TestCase;

use Core\Domain\Entity\Author;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Repository\AuthorRepositoryInterface;

use Core\UseCase\Author\CreateAuthorUseCase;
use Core\UseCase\DTO\Author\Input\RequestCreateAuthorDTO;
use Core\UseCase\DTO\Author\Output\ResponseCreateAuthorDTO;


class CreateAuthorUserCaseUnitTest extends TestCase
{
    /**
     * Test use case to create a new author.
     * @throws EntityValidationException
     */
    public function testCreateAuthor()
    {
        $authorName = 'Erik Urbanski';

        $this->mockAuthorEntity = Mockery::mock(Author::class, [$authorName]);
        $this->mockAuthorEntity
            ->shouldReceive('name')
            ->andReturn($authorName);

        $this->mockAuthorEntity
            ->shouldReceive('formatCreatedAt')
            ->andReturn();

        $this->mockAuthorRepository = Mockery::mock(stdClass::class, AuthorRepositoryInterface::class);
        $this->mockAuthorRepository
            ->shouldReceive('insert')
            ->andReturn($this->mockAuthorEntity);

        $this->mockRequestCreateAuthorDTO = Mockery::mock(RequestCreateAuthorDTO::class, [$authorName]);

        $authorUseCase = new CreateAuthorUseCase($this->mockAuthorRepository);
        $responseUseCase = $authorUseCase->execute($this->mockRequestCreateAuthorDTO);

        $this->assertInstanceOf(ResponseCreateAuthorDTO::class, $responseUseCase);
        $this->assertEquals($authorName, $responseUseCase->name);

        /**
         * Check spies:
         */
        $this->spyAuthorRepository = Mockery::spy(stdClass::class, AuthorRepositoryInterface::class);
        $this->spyAuthorRepository
            ->shouldReceive('insert')
            ->andReturn($this->mockAuthorEntity);

        $authorUseCase = new CreateAuthorUseCase($this->spyAuthorRepository);
        $authorUseCase->execute($this->mockRequestCreateAuthorDTO);

        $this->spyAuthorRepository->shouldHaveReceived('insert');

        Mockery::close();
    }
}
