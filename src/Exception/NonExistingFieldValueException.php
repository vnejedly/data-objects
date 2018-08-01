<?php
namespace Hooloovoo\DataObjects\Exception;

use Throwable;

/**
 * Class NonExistingFieldValueException
 */
class NonExistingFieldValueException extends RuntimeException
{
    /**
     * NonExistingFieldValueException constructor.
     *
     * @param string $fieldName
     * @param mixed $value
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $fieldName, $value, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Value $value for field $fieldName does not exist in collection", $code, $previous);
    }
}