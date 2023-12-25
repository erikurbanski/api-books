<?php

namespace App\Exceptions;

use Throwable;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Exception\NotFoundRegisterException;



class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    /**
     * Render errors.
     * @param $request
     * @param Throwable $e
     * @return JsonResponse|null
     * @throws Throwable
     */
    public function render($request, Throwable $e): ?JsonResponse
    {
        if ($e instanceof NotFoundRegisterException) {
            return $this->showError(
                message: $e->getMessage(),
                statusCode: Response::HTTP_NOT_FOUND,
            );
        }

        if ($e instanceof EntityValidationException) {
            return $this->showError(
                message: $e->getMessage(),
                statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }

        return parent::render($request, $e);
    }

    /**
     * Show message of error.
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    private function showError(string $message, int $statusCode): JsonResponse
    {
        $data = [
            'message' => $message,
        ];

        return response()->json($data, $statusCode);
    }
}
