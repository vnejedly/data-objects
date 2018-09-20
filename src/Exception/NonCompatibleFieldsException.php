<?php
namespace Hooloovoo\DataObjects\Exception;

use Hooloovoo\DataObjects\Field\FieldInterface;
use Throwable;

/**
 * Class NonCompatibleFieldsException
 */
class NonCompatibleFieldsException extends LogicException implements ComparisonException
{
    /** @var FieldInterface */
    protected $fieldA;

    /** @var FieldInterface */
    protected $fieldB;

    /**
     * NonCompatibleFieldsException constructor.
     *
     * @param FieldInterface $fieldA
     * @param FieldInterface $fieldB
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        FieldInterface $fieldA,
        FieldInterface $fieldB,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct(
            "Field type {$fieldA->getType()} can not be compared with field type {$fieldB->getType()}",
            $code, $previous
        );

        $this->fieldA = $fieldA;
        $this->fieldB = $fieldB;
    }

    /**
     * @return FieldInterface
     */
    public function getFieldA(): FieldInterface
    {
        return $this->fieldA;
    }

    /**
     * @return FieldInterface
     */
    public function getFieldB(): FieldInterface
    {
        return $this->fieldB;
    }
}