<?php

namespace Core\UseCase\Author;

use Core\Domain\Repository\AuthorRepositoryInterface;
use Core\UseCase\DTO\Author\Input\RequestListAuthorsDTO;
use Core\UseCase\DTO\Author\Output\ResponseListAuthorsDTO;

class ListAuthorsUseCase
{
    /**
     * Constructor class.
     * @param AuthorRepositoryInterface $repository
     */
    public function __construct(
        protected AuthorRepositoryInterface $repository
    )
    {
    }

    /**
     * Paginate results to authors.
     * @param RequestListAuthorsDTO $inputs
     * @return ResponseListAuthorsDTO
     */
    public function execute(RequestListAuthorsDTO $inputs): ResponseListAuthorsDTO
    {
        $authors = $this->repository->paginate(
            filter: $inputs->filter,
            order: $inputs->order,
            page: $inputs->page,
            totalPerPage: $inputs->totalPerPage,
        );

        return new ResponseListAuthorsDTO(
            items: $authors->items(),
            total: $authors->total(),
            last_page: $authors->lastPage(),
            first_page: $authors->firstPage(),
            per_page: $authors->perPage(),
            current_page: $authors->currentPage(),
            to: $authors->to(),
            from: $authors->from(),
        );
    }
}
