<?php

namespace Tests\Unit\Domain\Entity;

use Throwable;
use PHPUnit\Framework\TestCase;

use Core\Domain\Entity\Author;
use Core\Domain\Exception\EntityValidationException;

class AuthorUnitTest extends TestCase
{
    /**
     * Test author attributes.
     * @return void
     */
    public function testAttributes()
    {
        $author = new Author(
            name: 'Erik Urbanski',
        );

        $this->assertEmpty($author->id());
        $this->assertNotEmpty($author->formatCreatedAt());
        $this->assertEquals('Erik Urbanski', $author->name);
    }

    /**
     * Test update data author.
     * @return void
     * @throws EntityValidationException
     */
    public function testUpdate()
    {
        $author = new Author(
            name: 'Erik Urbanski',
            id: 20,
            createdAt: '2023-12-01',
        );

        $author->update(
            name: 'Erik Urbanski Santos'
        );

        $this->assertEquals('Erik Urbanski Santos', $author->name);
    }

    /**
     * Test validation rules to author name.
     * @return void
     */
    public function testExceptionName()
    {
        try {
            new Author(name: 'A');
            $this->fail();
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
}
