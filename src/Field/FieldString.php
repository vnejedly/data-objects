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
     * FieldString constructor.
     * @param string $value
     */
    public function __construct(string $value = null)
    {
        $this->_value = $value;
    }
}