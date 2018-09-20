<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\DataObjectInterface;
use Hooloovoo\DataObjects\Exception\NonComparableFieldException;
use Hooloovoo\DataObjects\Exception\NonCompatibleFieldsException;
use Hooloovoo\DataObjects\Field\Exception\InvalidValueException;

/**
 * Class FieldDataObject
 */
class FieldDataObject extends AbstractField
{
    const TYPE = DataObjectInterface::class;

    /** @var DataObjectInterface */
    protected $_value;

    /**
     * @param DataObjectInterface $value
     */
    protected function _setValue($value = null)
    {
        if (!is_null($value) && !$value instanceof DataObjectInterface) {
            throw new InvalidValueException(self::class, $value);
        }

        $this->_value = $value;
    }

    /**
     * @return bool
     */
    public function isUnlocked() : bool
    {
        if (is_null($this->_value)) {
            return $this->_unlocked;
        }

        return $this->_unlocked || $this->_value->isUnlocked();
    }

    /**
     * @return array
     */
    public function getSerialized()
    {
        if (is_null($this->_value)) {
            return null;
        }

        return $this->_value->getSerialized();
    }

    /**
     * @param FieldInterface $field
     * @param bool $direction
     * @return int
     */
    public function compareWith(FieldInterface $field, bool $direction): int
    {
        throw new NonComparableFieldException($this);
    }
}
