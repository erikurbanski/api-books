<?php

namespace Tests\Unit\App\Http\Controllers;

use Mockery;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

use App\Http\Controllers\AuthorController;

use Core\UseCase\Author\ListAuthorsUseCase;
use Core\UseCase\DTO\Author\Output\ResponseListAuthorsDTO;

class AuthorControllersUnitTest extends TestCase
{
    public function testIndex()
    {
        $mockRequest = Mockery::mock(Request::class);
        $mockRequest
            ->shouldReceive('get')
            ->andReturn('test');

        $mockAuthorResponseDTO = Mockery::mock(ResponseListAuthorsDTO::class, [
            [], 1, 1, 1, 1, 1, 1, 1
        ]);

        $mockUseCase = Mockery::mock(ListAuthorsUseCase::class);
        $mockUseCase
            ->shouldReceive('execute')
            ->andReturn($mockAuthorResponseDTO);

        $controller = new AuthorController();
        $response = $controller->index($mockRequest, $mockUseCase);

        $this->assertIsObject($response->resource);
        $this->assertArrayHasKey('meta', $response->additional);

        $mockUseCaseSpy = Mockery::spy(ListAuthorsUseCase::class);
        $mockUseCaseSpy
            ->shouldReceive('execute')
            ->andReturn($mockAuthorResponseDTO);

        $controller->index($mockRequest, $mockUseCaseSpy);
        $mockUseCaseSpy->shouldReceive('execute');

        Mockery::close();
    }
}
