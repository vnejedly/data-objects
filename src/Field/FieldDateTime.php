<?php
namespace Hooloovoo\DataObjects\Field;

use DateTime;

/**
 * Class FieldDateTime
 */
class FieldDateTime extends AbstractField
{
    const TYPE = DateTime::class;

    /** @var DateTime */
    protected $_value;

    /**
     * FieldDateTime constructor.
     * @param DateTime $value
     */
    public function __construct(DateTime $value = null)
    {
        $this->_value = $value;
    }

    /**
     * @param DateTime $value
     */
    public function setValue($value)
    {
        $this->_setValue($value);
    }

    /**
     * @param DateTime $value
     */
    protected function _setValue(DateTime $value)
    {
        $this->_value = $value;
    }

    /**
     * @return string
     */
    public function getSerialized()
    {
        return $this->_value->format(DateTime::W3C);
    }
}