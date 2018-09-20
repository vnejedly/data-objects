<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\Exception\NonComparableFieldException;
use Hooloovoo\DataObjects\Exception\NonCompatibleFieldsException;
use Hooloovoo\DataObjects\FieldSetInterface;
use Hooloovoo\ORM\Exception\ComputedFieldUnsettableException;
use Hooloovoo\ORM\Exception\InvalidCallbackException;

/**
 * Class FieldComputed
 */
class FieldComputed extends AbstractField
{
    /** @var FieldSetInterface */
    protected $fieldSet;

    /** @var callable */
    protected $callbackSet;

    /** @var callable */
    protected $callbackGet;

    /**
     * FieldComputed constructor.
     *
     * @param callable $callbackGet
     * @param callable|null $callbackSet
     */
    public function __construct(callable $callbackGet, callable $callbackSet = null)
    {
        if (is_null($callbackSet)) {
            $callbackSet = function (FieldSetInterface $fieldSet, $value) {
                throw new ComputedFieldUnsettableException(get_class($fieldSet), $value);
            };
        }

        if (!is_callable($callbackGet) || !is_callable($callbackSet)) {
            throw new InvalidCallbackException();
        }

        $this->callbackGet = $callbackGet;
        $this->callbackSet = $callbackSet;
    }

    /**
     * @param FieldSetInterface $fieldSet
     */
    public function setFieldSet(FieldSetInterface $fieldSet)
    {
        $this->fieldSet = $fieldSet;
    }

    /**
     * @return mixed
     */
    public function getSerialized()
    {
        return $this->getValue();
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        $callback = &$this->callbackGet;
        return $callback($this->fieldSet);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    protected function _setValue($value = null)
    {
        $callback = &$this->callbackSet;
        $callback($value, $this->fieldSet);
    }

    /**
     * @param FieldInterface $field
     * @param bool $direction
     * @return int
     */
    public function compareWith(FieldInterface $field, bool $direction): int
    {
        if (!$field instanceof self) {
            throw new NonCompatibleFieldsException($this, $field);
        }

        if (is_numeric($this->getValue())) {
            if (!is_numeric($field->getValue())) {
                throw new NonCompatibleFieldsException($this, $field);
            }

            return $this->numberCompare($this->getValue(), $field->getValue(), $direction);
        }

        if (is_string($this->getValue())) {
            if (!is_string($field->getValue())) {
                throw new NonCompatibleFieldsException($this, $field);
            }

            return $this->stringCompare($this->getValue(), $field->getValue(), $direction);
        }

        throw new NonComparableFieldException($this);
    }
}