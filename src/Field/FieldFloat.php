<?php
namespace Hooloovoo\DataObjects\Field;

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
    public function setValue($value)
    {
        $this->_setValue($value);
    }

    /**
     * @param float $value
     */
    protected function _setValue(float $value = null)
    {
        $this->_value = $value;
    }
}