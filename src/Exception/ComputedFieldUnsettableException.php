<?php
namespace Hooloovoo\ORM\Exception;

use Hooloovoo\DataObjects\Exception\LogicException;
use Throwable;

/**
 * Class ComputedFieldUnsettableException
 */
class ComputedFieldUnsettableException extends LogicException
{
    /**
     * ComputedFieldUnsettableException constructor.
     *
     * @param string $className
     * @param int $value
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $className, $value, $code = 0, Throwable $previous = null)
    {
        parent::__construct("Computed field of entity $className has no setter callback (trying to set value = $value)", $code, $previous);
    }
}