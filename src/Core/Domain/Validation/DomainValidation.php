<?php

namespace Core\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation
{
    /**
     * Check value is null.
     * @throws EntityValidationException
     */
    public static function notNull(
        string      $value,
        string|null $exceptMessage = null
    ): void
    {
        if (empty($value)) {
            throw new EntityValidationException($exceptMessage ?? 'Should not be empty!');
        }
    }

    /**
     * Check max length in string.
     * @throws EntityValidationException
     */
    public static function stringMaxLength(
        string      $value,
        int         $length = 255,
        string|null $exceptMessage = null
    ): void
    {
        if (strlen($value) >= $length) {
            throw new EntityValidationException($exceptMessage ?? "The value must not be greater than {$length}.");
        }
    }

    /**
     * Check min length in string.
     * @throws EntityValidationException
     */
    public static function stringMinLength(
        string      $value,
        int         $length = 3,
        string|null $exceptMessage = null
    ): void
    {
        if (strlen($value) < $length) {
            throw new EntityValidationException($exceptMessage ?? "The value must not be less than {$length}.");
        }
    }
}