<?php

namespace Tests\Unit\Domain\Entity;

use Throwable;
use PHPUnit\Framework\TestCase;

use Core\Domain\Entity\Subject;
use Core\Domain\Exception\EntityValidationException;

class SubjectUnitTest extends TestCase
{
    /**
     * Test subject attributes.
     * @return void
     */
    public function testAttributes()
    {
        $subject = new Subject(
            description: 'Finance',
        );

        $this->assertEmpty($subject->id());
        $this->assertNotEmpty($subject->formatCreatedAt());
        $this->assertEquals('Finance', $subject->description);
    }

    /**
     * Test update data subject.
     * @return void
     * @throws EntityValidationException
     */
    public function testUpdate()
    {
        $subject = new Subject(
            description: 'Loves',
            createdAt: '2023-12-01',
            updatedAt: '2023-12-01',
            id: 299,
        );

        $subject->update(
            description: 'Loves'
        );

        $this->assertEquals('Loves', $subject->description);
    }

    /**
     * Test validation rules to subject description.
     * @return void
     */
    public function testExceptionDescription()
    {
        try {
            new Subject(description: 'A1');
            $this->fail();
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
}
