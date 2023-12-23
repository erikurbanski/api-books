<?php

namespace App\Repositories\Presenters;

use Core\Domain\Repository\PaginationInterface;

class PaginatorPresenter implements PaginationInterface
{
    public function items(): array
    {
        return 0;
    }

    public function to(): int
    {
        return 0;
    }

    public function from(): int
    {
        return 0;
    }

    public function total(): int
    {
        return 0;
    }

    public function perPage(): int
    {
        return 0;
    }

    public function lastPage(): int
    {
        return 0;
    }

    public function firstPage(): int
    {
        return 0;
    }
}
