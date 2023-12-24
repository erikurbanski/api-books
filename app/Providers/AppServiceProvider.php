<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Transaction\DatabaseTransaction;
use App\Repositories\Eloquent\AuthorEloquentRepository;

use Core\UseCase\Interfaces\TransactionInterface;
use Core\Domain\Repository\AuthorRepositoryInterface;

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
