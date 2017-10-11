<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\Field\Exception\InvalidValueException;

/**
 * Class FieldFloat
 */
class FieldFloat extends AbstractField
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
}