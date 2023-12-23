<?php

namespace Tests\Unit\App\Models;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;

abstract class ModelTestCase extends TestCase
{
    abstract protected function model(): Model;

    abstract protected function traits(): array;

    abstract protected function filled(): array;

    abstract protected function casts(): array;

    /**
     * A basic unit test to test traits in models.
     * @return void
     */
    public function testIfUseTraits(): void
    {
        $traitsNeeded = $this->traits();

        $traitsUsed = array_keys(class_uses($this->model()));

        $this->assertEquals($traitsNeeded, $traitsUsed);
    }

    /**
     * Check filled attributes in models.
     * @return void
     */
    public function testHasFilled(): void
    {
        $expected = $this->filled();

        $filled = $this->model()->getFillable();

        $this->assertEquals($expected, $filled);
    }

    /**
     * Check casts attributes in models.
     * @return void
     */
    public function testCasts(): void
    {
        $expectedCasts = $this->casts();

        $casts = $this->model()->getCasts();

        $this->assertEquals($expectedCasts, $casts);
    }
}
