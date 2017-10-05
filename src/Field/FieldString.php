<?php
namespace Hooloovoo\DataObjects\Field;

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
    public function setValue($value)
    {
        $this->_setValue($value);
    }

    /**
     * @param string $value
     */
    protected function _setValue(string $value = null)
    {
        $this->_value = $value;
    }
}