<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\Field\Exception\InvalidValueException;

/**
 * Class FieldArray
 */
class FieldArray extends AbstractField
{
    const TYPE = 'array';

    /** @var array */
    protected $_value;

    /**
     * @param array $value
     */
    protected function _setValue($value = null)
    {
        if (!is_null($value) && !is_array($value)) {
            throw new InvalidValueException(self::class, $value);
        }

        $this->_value = $value;
    }
}