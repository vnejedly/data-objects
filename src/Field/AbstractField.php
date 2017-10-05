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

    /**
     * FieldString constructor.
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        $this->setValue($value);
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
     * @return mixed
     */
    public function getSerialized()
    {
        return $this->_value;
    }
}