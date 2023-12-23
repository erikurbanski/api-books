<?php

namespace Tests\Unit\Domain\Validation;

use Throwable;
use PHPUnit\Framework\TestCase;

use Core\Domain\Validation\DomainValidation;
use Core\Domain\Exception\EntityValidationException;

class DomainValidationUnitTest extends TestCase
{
    /**
     * Validation test to check any value.
     * @return void
     */
    public function testNotNull()
    {
        try {
            DomainValidation::notNull(value:'');
            $this->fail();
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    /**
     * Validation test to check any value with custom message error.
     * @return void
     */
    public function testNotNullCustomMessageException()
    {
        try {
            DomainValidation::notNull(
                value: '',
                exceptMessage: 'Custom message error!',
            );
            $this->fail();
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Custom message error!');
        }
    }

    /**
     * Check max length in string.
     * @return void
     */
    public function testStringMaxLength()
    {
        try {
            DomainValidation::stringMaxLength(
                value: 'Erik Urbanski',
                length: 10,
                exceptMessage: 'Custom message error!',
            );
            $this->fail();
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Custom message error!');
        }
    }

    /**
     * Check min length in string.
     * @return void
     */
    public function testStringMinLength()
    {
        try {
            DomainValidation::stringMinLength(
                value: 'Teste',
                length: 8,
                exceptMessage: 'Custom message error!',
            );
            $this->fail();
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Custom message error!');
        }
    }
}