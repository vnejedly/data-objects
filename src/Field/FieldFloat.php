<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\Exception\NonCompatibleFieldsException;
use Hooloovoo\DataObjects\Field\Exception\InvalidValueException;

/**
 * Class FieldFloat
 */
class FieldFloat extends AbstractField implements ScalarFieldInterface
{
    const TYPE = 'float';


    /** @var float */
    protected $_value;

    /**
     * @param float $value
     */
    protected function _setValue($value = null)
    {
        if (is_null($value) || is_float($value) || is_numeric($value)) {
            $this->_value = $value;
            return;
        }

        if (is_string($value)) {
            $floatValue = (float) $value;
            if ((string) $floatValue === $value) {
                $this->_value = $floatValue;
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