<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\Exception\NonCompatibleFieldsException;
use Hooloovoo\DataObjects\Field\Exception\InvalidValueException;

/**
 * Class FieldInt
 */
class FieldInt extends AbstractField implements ScalarFieldInterface
{
    const TYPE = 'int';

    /** @var int */
    protected $_value;

    /**
     * @param int $value
     */
    protected function _setValue($value = null)
    {
        if (is_null($value) || is_int($value)) {
            $this->_value = $value;
            return;
        }

        if (is_numeric($value)) {
            $intValue = (int) $value;
            if ((string) $intValue === (string) $value) {
                $this->_value = $intValue;
                return;
            }
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

        return (string) $this->_value;
    }
}