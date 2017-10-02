<?php
namespace Hooloovoo\DataObjects\Field;

/**
 * Class FieldInt
 */
class FieldInt extends AbstractField
{
    const TYPE = 'int';

    /** @var int */
    protected $_value;

    /**
     * FieldInt constructor.
     * @param int $value
     */
    public function __construct(int $value = null)
    {
        $this->_value = $value;
    }

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->_setValue($value);
    }

    /**
     * @param int $value
     */
    protected function _setValue(int $value)
    {
        $this->_value = $value;
    }
}