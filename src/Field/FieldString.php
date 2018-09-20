<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\Exception\NonCompatibleFieldsException;
use Hooloovoo\DataObjects\Field\Exception\InvalidValueException;

/**
 * Class FieldString
 */
class FieldString extends AbstractField
{
    const TYPE = 'string';

    /** @var string */
    protected $_value;

    /**
     * @param string $value
     */
    protected function _setValue($value = null)
    {
        if (is_null($value) || is_string($value)) {
            $this->_value = $value;
            return;
        }

        if (is_numeric($value)) {
            $this->_value = (string) $value;
            return;
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

        return $this->stringCompare($this->getValue(), $field->getValue(), $direction);
    }
}