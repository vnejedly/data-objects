<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\Field\Exception\InvalidValueException;

/**
 * Class FieldBool
 */
class FieldBool extends AbstractField
{
    const TYPE = 'bool';

    /** @var bool */
    protected $_value;

    /** @var bool[] */
    protected $_stringVal = [
        'true' => true,
        'false' => false,
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
}