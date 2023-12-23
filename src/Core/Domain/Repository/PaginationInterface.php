<?php

namespace Core\Domain\Repository;

use stdClass;

interface PaginationInterface
{
    /**
     * @return stdClass[]
     */
    public function items(): array;

    public function to(): int;

    public function from(): int;

    public function total(): int;

    public function perPage(): int;

    public function lastPage(): int;

    public function firstPage(): int;
}