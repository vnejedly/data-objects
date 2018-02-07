<?php
namespace Hooloovoo\DataObjects\Field;

/**
 * Class AbstractField
 */
abstract class AbstractField implements FieldInterface
{
    const TYPE = 'mixed';

    /** @var mixed */
    protected $_value;

    /** @var bool */
    protected $_unlocked = false;

    /**
     * FieldString constructor.
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        $this->_setValue($value);
    }

    /**
     * @param float $value
     */
    public function setValue($value)
    {
        $this->_setValue($value);
        $this->_unlocked = true;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return static::TYPE;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * @return bool
     */
    public function isUnlocked() : bool
    {
        return $this->_unlocked;
    }

    /**
     * @return mixed
     */
    public function getSerialized()
    {
        return $this->_value;
    }

    /**
     * @param $value
     */
    abstract protected function _setValue($value = null);
}