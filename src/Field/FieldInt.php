<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\Field\Exception\InvalidValueException;

/**
 * Class FieldInt
 */
class FieldInt extends AbstractField
{
    const TYPE = 'int';

    /** @var int */
    protected $_value;

    /**
     * @param int $value
     */
    protected function _setValue($value = null)
    {
        if (is_int($value)) {
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
}