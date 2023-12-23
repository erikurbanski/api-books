<?php

namespace Tests\Unit\Domain\Entity;

use Throwable;
use Exception;
use PHPUnit\Framework\TestCase;

use Core\Domain\Entity\Book;
use Core\Domain\Exception\EntityValidationException;

class BookUnitTest extends TestCase
{
    /**
     * Test book attributes.
     * @return void
     * @throws Exception
     */
    public function testAttributes()
    {
        $book = new Book(
            title: 'Design Patterns',
            publisher: 'Atlas',
            edition: 2,
            year: '2023',
            value: 54.89,
        );

        $this->assertEmpty($book->id());
        $this->assertNotEmpty($book->formatCreatedAt());
        $this->assertNotEmpty($book->formatCreatedAt());

        $this->assertEquals('Design Patterns', $book->title);
    }

    /**
     * Test if year publishing attribute is valid.
     * @return void
     * @throws Exception
     */
    public function testYearPublishingAttribute()
    {
        try {
            new Book(
                title: 'Design Patterns',
                publisher: 'Atlas',
                edition: 2,
                year: '2025', # Year bigger than current year
                value: 54.89,
            );
            $this->fail();
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    /**
     * Test if year length attribute is valid.
     * @return void
     * @throws Exception
     */
    public function testYearLengthAttribute()
    {
        try {
            new Book(
                title: 'Design Patterns',
                publisher: 'Atlas',
                edition: 2,
                year: '100', # Year have only 3 characters.
                value: 54.89,
            );
            $this->fail();
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    /**
     * Test update data book.
     * @return void
     * @throws Exception
     */
    public function testUpdate()
    {
        $book = new Book(
            title: 'Design Patterns',
            publisher: 'Atlas',
            edition: 2,
            year: '2022', # Year have only 3 characters.
            value: 54.89,
            createdAt: '2023-12-01',
            updatedAt: '2023-12-01',
        );

        $book->update(
            title: 'Design Patterns - New Edition',
            publisher: 'Atlas',
            edition: 3,
            year: '2023',
            value: 68.90,
        );

        $this->assertEquals('Atlas', $book->publisher);

        $this->assertNotEquals(2, $book->edition);
        $this->assertNotEquals(54.89, $book->value);
        $this->assertNotEquals('2022', $book->year);
        $this->assertNotEquals('Design Patterns', $book->title);
    }

    /**
     * Test validation rules to book title.
     * @return void
     */
    public function testExceptionTitle()
    {
        try {
            new Book(
                title: 'DD',
                publisher: 'Atlas',
                edition: 2,
                year: '2023',
                value: 54.89,
            );
            $this->fail();
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    /**
     * Test validation rules to book publisher.
     * @return void
     */
    public function testExceptionPublisherEmpty()
    {
        try {
            new Book(
                title: 'SOLID and TDD',
                publisher: '',
                edition: 2,
                year: '2023',
                value: 54.89,
            );
            $this->fail();
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    /**
     * Test validation rules to price of book.
     * @return void
     */
    public function testExceptionBookPriceValueIsNegative()
    {
        try {
            new Book(
                title: 'SOLID and TDD',
                publisher: 'Erik Urbanski',
                edition: 2,
                year: '2023',
                value: -10.50,
            );
            $this->fail();
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
}
