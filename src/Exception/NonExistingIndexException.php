<?php
namespace Hooloovoo\DataObjects\Exception;

use Throwable;

/**
 * Class NonExistingIndexException
 */
class NonExistingIndexException extends RuntimeException
{
    /**
     * NonExistingIndexException constructor.
     *
     * @param string $fieldName
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $fieldName, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Index for field $fieldName does not exist in collection", $code, $previous);
    }
}