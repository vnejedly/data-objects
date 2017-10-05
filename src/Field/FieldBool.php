<?php
namespace Hooloovoo\DataObjects\Field;

/**
 * Class FieldBool
 */
class FieldBool extends AbstractField
{
    const TYPE = 'bool';

    /** @var bool */
    protected $_value;

    /**
     * @param bool $value
     */
    public function setValue($value)
    {
        $this->_setValue($value);
    }

    /**
     * @param bool $value
     */
    protected function _setValue(bool $value = null)
    {
        $this->_value = $value;
    }
}