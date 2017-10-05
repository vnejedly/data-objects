<?php
namespace Hooloovoo\DataObjects\Field;

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
    public function setValue($value)
    {
        $this->_setValue($value);
    }

    /**
     * @param array $value
     */
    protected function _setValue(array $value = null)
    {
        if (is_null($value)) {
            $value = [];
        }

        $this->_value = $value;
    }
}