<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\Exception\NonCompatibleFieldsException;
use Hooloovoo\DataObjects\Field\Exception\InvalidValueException;

/**
 * Class FieldBool
 */
class FieldBool extends AbstractField implements ScalarFieldInterface
{
    const TYPE = 'bool';

    const VAL_STRING_TRUE = 'true';
    const VAL_STRING_FALSE = 'false';

    /** @var bool */
    protected $_value;

    /** @var bool[] */
    protected $_stringVal = [
        self::VAL_STRING_TRUE => true,
        self::VAL_STRING_FALSE => false,
    ];

    /**
     * @param bool $value
     */
    protected function _setValue($value = null)
    {
        if (is_null($value) || is_bool($value)) {
            $this->_value = $value;
            return;
        }

        if (is_numeric($value)) {
            $this->_value = (bool) $value;
            return;
        }

        if (is_string($value) && array_key_exists($value, $this->_stringVal)) {
            $this->_value = $this->_stringVal[$value];
        }

        throw new InvalidValueException(self::class, $value);
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

        return $this->numberCompare($this->getValue(), $field->getValue(), $direction);
    }

    /**
     * @return string
     */
    public function getStringValue(): ?string
    {
        if (is_null($this->_value)) {
            return null;
        }

        if ($this->_value) {
            return self::VAL_STRING_TRUE;
        }

        return self::VAL_STRING_FALSE;
    }
}