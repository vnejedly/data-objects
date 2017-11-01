<?php
namespace Hooloovoo\DataObjects\Exception;

use Throwable;

/**
 * Class NonExistingFieldException
 */
class NonExistingFieldException extends LogicException
{
    /** @var string */
    protected $fieldName;

    /**
     * NonExistingFieldException constructor.
     *
     * @param string $fieldName
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $fieldName, $code = 0, Throwable $previous = null)
    {
        $class = static::class;
        parent::__construct("Field $fieldName does not exist in entity $class", $code, $previous);
        $this->fieldName = $fieldName;
    }

    /**
     * @return string
     */
    public function getFieldName() : string
    {
        return $this->fieldName;
    }
}