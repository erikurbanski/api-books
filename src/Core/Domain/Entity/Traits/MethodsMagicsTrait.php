<?php

namespace Core\Domain\Entity\Traits;

use DateTime;
use Exception;

trait MethodsMagicsTrait
{
    /**
     * Magic method.
     * @throws Exception
     */
    public function __get($property)
    {
        if (isset($this->{$property})) {
            return $this->{$property};
        }

        $className = get_class($this);
        throw new Exception("Property {$property} not found in class {$className}!");
    }

    /**
     * Return ID value.
     * @return int|null
     */
    public function id(): ?int
    {
        return $this->id;
    }

    /**
     * Convert created date to string and formatted.
     * @param string $format
     * @return string
     */
    public function formatCreatedAt(string $format = 'Y-m-d'): string
    {
        return $this->createdAt->format($format);
    }

    /**
     * Convert update date to string and formatted.
     * @param string $format
     * @return string
     */
    public function formatUpdatedAt(string $format = 'Y-m-d'): string
    {
        return $this->updatedAt->format($format);
    }
}
