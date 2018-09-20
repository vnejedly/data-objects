<?php
namespace Hooloovoo\DataObjects\Exception;

use Hooloovoo\DataObjects\Field\FieldInterface;
use Throwable;

/**
 * Class NonComparableFieldException
 */
class NonComparableFieldException extends LogicException implements ComparisonException
{
    /** @var FieldInterface */
    protected $field;

    /**
     * NonComparableFieldException constructor.
     *
     * @param FieldInterface $field
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(FieldInterface $field, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Field type {$field->getType()} can not be compared", $code, $previous);
        $this->field = $field;
    }

    /**
     * @return FieldInterface
     */
    public function getField(): FieldInterface
    {
        return $this->field;
    }
}