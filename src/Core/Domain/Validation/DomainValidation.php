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
            throw new EntityValidationException($exceptMessage ?? "The value must not be greater than $length.");
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
            throw new EntityValidationException($exceptMessage ?? "The value must not be less than $length.");
        }
    }

    /**
     * Check value is negative.
     * @throws EntityValidationException
     */
    public static function notNegative(
        float|int   $value,
        string|null $exceptMessage = null
    ): void
    {
        if ($value < 0) {
            throw new EntityValidationException($exceptMessage ?? "Value cannot be less than zero.");
        }
    }

    /**
     * Check year is valid.
     * @throws EntityValidationException
     */
    public static function validYear(
        string      $year,
        string|null $exceptMessage = null
    ): void
    {
        if (strlen($year) <> 4) {
            throw new EntityValidationException($exceptMessage ?? "Year cannot have more than 4 characters.");
        }

        $currentYear = date(format: 'Y');
        if (strtotime($year) > strtotime($currentYear)) {
            throw new EntityValidationException($exceptMessage ?? "$year is bigger than the current year");
        }

        $year = (int) $year;
        if (!checkdate(1, 1, $year)) {
            throw new EntityValidationException($exceptMessage ?? "Invalid year $year.");
        }
    }
}
