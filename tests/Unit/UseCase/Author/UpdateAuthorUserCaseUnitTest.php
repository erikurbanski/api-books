<?php

namespace Tests\Unit\UseCase\Author;

use Mockery;
use stdClass;
use PHPUnit\Framework\TestCase;

use Core\Domain\Entity\Author;
use Core\Domain\Repository\AuthorRepositoryInterface;
use Core\Domain\Exception\EntityValidationException;

use Core\UseCase\Author\UpdateAuthorUseCase;
use Core\UseCase\DTO\Author\Input\RequestUpdateAuthorDTO;
use Core\UseCase\DTO\Author\Output\ResponseUpdateAuthorDTO;

class UpdateAuthorUserCaseUnitTest extends TestCase
{
    /**
     * Test use case to update data from author.
     * @throws EntityValidationException
     */
    public function testUpdateAuthor()
    {
        $authorId = 22;
        $authorName = 'Joana Alencar';
        $authorCreatedAt = '2023-12-15';

        $this->mockAuthorEntity = Mockery::mock(Author::class, [
            $authorName,
            $authorId,
            $authorCreatedAt,
        ]);

        $this->mockAuthorEntity->shouldReceive('update');

        $this->mockAuthorRepository = Mockery::mock(stdClass::class, AuthorRepositoryInterface::class);
        $this->mockAuthorRepository
            ->shouldReceive('getById')
            ->once()
            ->with($authorId)
            ->andReturn($this->mockAuthorEntity);

        $this->mockAuthorRepository
            ->shouldReceive('update')
            ->once()
            ->andReturn($this->mockAuthorEntity);

        $authorUpdateName = 'Joana Alencar Update';
        $this->mockRequestUpdateAuthorDTO = Mockery::mock(RequestUpdateAuthorDTO::class, [
            $authorId,
            $authorUpdateName,
        ]);

        $updateUseCase = new UpdateAuthorUseCase($this->mockAuthorRepository);
        $responseUseCase = $updateUseCase->execute($this->mockRequestUpdateAuthorDTO);

        $this->assertInstanceOf(ResponseUpdateAuthorDTO::class, $responseUseCase);

        Mockery::close();
    }
}