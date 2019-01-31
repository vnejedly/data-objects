<?php
namespace Hooloovoo\DataObjects\Field;

use DateTime;
use Hooloovoo\DataObjects\Exception\NonCompatibleFieldsException;
use Hooloovoo\DataObjects\Field\Exception\InvalidValueException;

/**
 * Class FieldDateTime
 */
class FieldDateTime extends AbstractField implements ScalarFieldInterface
{
    const TYPE = DateTime::class;
    const FORMAT_TIMESTAMP = 'c';

    /** @var DateTime */
    protected $_value;

    /**
     * @param DateTime $value
     */
    protected function _setValue($value = null)
    {
        if (!is_null($value) && !$value instanceof DateTime) {
            throw new InvalidValueException(self::class, $value);
        }

        $this->_value = $value;
    }

    /**
     * @return string
     */
    public function getSerialized()
    {
        if (is_null($this->_value)) {
            return null;
        }

        return $this->_value->format(DateTime::W3C);
    }

    /**
     * @param FieldInterface $field
     * @param bool $direction
     * @return int
     */
    public function compareWith(FieldInterface $field, bool $direction): int
    {
        if (!$field instanceof self) {
            throw new NonCompatibleFieldsException($this, $field);
        }

        return $this->numberCompare(
            $this->getValue()->format(static::FORMAT_TIMESTAMP),
            $field->getValue()->format(static::FORMAT_TIMESTAMP),
            $direction
        );
    }

    /**
     * @return string
     */
    public function getStringValue(): ?string
    {
        if (is_null($this->_value)) {
            return null;
        }

        return $this->_value->format(DateTime::W3C);
    }
}