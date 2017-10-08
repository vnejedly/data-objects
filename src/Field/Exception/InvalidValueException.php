<?php
namespace Hooloovoo\DataObjects\Field\Exception;

use Hooloovoo\DataObjects\Exception\RuntimeException;
use Throwable;

/**
 * Class InvalidValueException
 */
class InvalidValueException extends RuntimeException
{
    /**
     * InvalidValueException constructor.
     *
     * @param string $fieldType
     * @param mixed $value
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $fieldType, $value, $code = 0, Throwable $previous = null)
    {
        $exportValue = var_export($value, true);
        parent::__construct("Invalid value for DO field (type = $fieldType, value = $exportValue)", $code, $previous);
    }
}