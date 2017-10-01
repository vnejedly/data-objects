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
     * FieldBool constructor.
     * @param bool $value
     */
    public function __construct(bool $value = null)
    {
        $this->_value = $value;
    }
}