<?php

namespace Tests\Unit\App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubjectUnitTest extends ModelTestCase
{
    /**
     * Get author model.
     * @return Model
     */
    protected function model(): Model
    {
        return new Subject();
    }

    protected function traits(): array
    {
        return [HasFactory::class];
    }

    protected function filled(): array
    {
        return [
            'description',
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'int',
        ];
    }
}
