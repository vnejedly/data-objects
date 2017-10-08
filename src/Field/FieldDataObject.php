<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\DataObjectInterface;
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
        if (!$value instanceof DataObjectInterface) {
            throw new InvalidValueException(self::class, $value);
        }

        $this->_value = $value;
    }

    /**
     * @return array
     */
    public function getSerialized()
    {
        return $this->_value->getSerialized();
    }
}