<?php

namespace Tests\Unit\App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookUnitTest extends ModelTestCase
{
    /**
     * Get author model.
     * @return Model
     */
    protected function model(): Model
    {
        return new Book();
    }

    protected function traits(): array
    {
        return [HasFactory::class];
    }

    protected function filled(): array
    {
        return [
            'title',
            'publisher',
            'year',
            'edition',
            'value',
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'int',
            'value' => 'float',
        ];
    }
}
