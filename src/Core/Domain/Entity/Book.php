<?php

namespace Core\Domain\Entity;

class Book
{
    /**
     * Constructor class.
     * @param int|null $id
     * @param string $title
     * @param string $company
     * @param int|null $edition
     * @param string $yearOfPublication
     */
    public function __construct(
        protected int|null $id = null,
        protected string   $title = '',
        protected string   $company = '',
        protected int|null $edition = null,
        protected string   $yearOfPublication = '',
    )
    {
    }
}