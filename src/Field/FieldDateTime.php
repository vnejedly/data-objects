<?php
namespace Hooloovoo\DataObjects\Field;

use DateTime;
use Hooloovoo\DataObjects\Field\Exception\InvalidValueException;

/**
 * Class FieldDateTime
 */
class FieldDateTime extends AbstractField
{
    const TYPE = DateTime::class;

    /** @var DateTime */
    protected $_value;

    /**
     * @param DateTime $value
     */
    protected function _setValue($value = null)
    {
        if (!$value instanceof DateTime) {
            throw new InvalidValueException(self::class, $value);
        }

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