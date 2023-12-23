<?php

namespace Tests\Unit\App\Models;

use App\Models\Author;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuthorUnitTest extends ModelTestCase
{
    /**
     * Get author model.
     * @return Model
     */
    protected function model(): Model
    {
        return new Author();
    }

    protected function traits(): array
    {
        return [HasFactory::class];
    }

    protected function filled(): array
    {
        return ['name'];
    }

    protected function casts(): array
    {
        return [
            'id' => 'int'
        ];
    }
}
