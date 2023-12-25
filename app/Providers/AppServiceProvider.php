<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Transaction\DatabaseTransaction;
use App\Repositories\Eloquent\BookEloquentRepository;
use App\Repositories\Eloquent\AuthorEloquentRepository;
use App\Repositories\Eloquent\SubjectEloquentRepository;

use Core\UseCase\Interfaces\TransactionInterface;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\Repository\AuthorRepositoryInterface;
use Core\Domain\Repository\SubjectRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            AuthorRepositoryInterface::class,
            AuthorEloquentRepository::class,
        );

        $this->app->singleton(
            BookRepositoryInterface::class,
            BookEloquentRepository::class,
        );

        $this->app->singleton(
            SubjectRepositoryInterface::class,
            SubjectEloquentRepository::class,
        );

        # DB Transaction:
        $this->app->bind(
            TransactionInterface::class,
            DatabaseTransaction::class,
        );
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
    }
}
