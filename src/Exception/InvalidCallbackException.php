<?php
namespace Hooloovoo\ORM\Exception;

use Hooloovoo\DataObjects\Exception\LogicException;
use Throwable;

/**
 * Class InvalidCallbackException
 */
class InvalidCallbackException extends LogicException
{
    /**
     * InvalidCallbackException constructor.
     *
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($code = 0, Throwable $previous = null)
    {
        parent::__construct("Constructor value for computed field must be a Callable", $code, $previous);
    }
}