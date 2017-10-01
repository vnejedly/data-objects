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
     * FieldArray constructor.
     * @param array $value
     */
    public function __construct(array $value = null)
    {
        $this->_value = $value;
    }
}