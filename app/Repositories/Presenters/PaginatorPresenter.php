<?php

namespace App\Repositories\Presenters;

use stdClass;
use Illuminate\Pagination\LengthAwarePaginator;
use Core\Domain\Repository\PaginationInterface;

/**
 * Presenter is responsible for retrieving data from repositories, and formatting them to display them in the view.
 * @author Erik Urbanski
 */
class PaginatorPresenter implements PaginationInterface
{
    /**
     * Converted items.
     * @var stdClass[]
     */
    private array $_items;

    /**
     * Constructor class to pagination.
     * @param LengthAwarePaginator $paginator
     */
    public function __construct(
        protected LengthAwarePaginator $paginator
    )
    {
        $this->_items = $this->resolveItems(
            items: $this->paginator->items(),
        );
    }

    /**
     * Convert laravel collection in array of stdClass.
     * @param array $items
     * @return array
     */
    private function resolveItems(array $items): array
    {
        $response = [];

        foreach ($items as $item) {
            $stdClass = new stdClass();
            foreach ($item->toArray() as $key => $value) {
                $stdClass->{$key} = $value;
            }
            $response[] = $stdClass;
        }

        return $response;
    }

    /**
     * Get items of pagination.
     * @return stdClass[]
     */
    public function items(): array
    {
        return $this->_items;
    }

    public function to(): int
    {
        return $this->paginator->firstItem() ?? 0;
    }

    public function from(): int
    {
        return $this->paginator->lastItem() ?? 0;
    }

    public function total(): int
    {
        return $this->paginator->total() ?? 0;
    }

    public function perPage(): int
    {
        return $this->paginator->perPage() ?? 0;
    }

    public function lastPage(): int
    {
        return $this->paginator->lastPage() ?? 0;
    }

    public function firstPage(): int
    {
        return $this->paginator->firstItem() ?? 0;
    }
}
