<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\DataObjectInterface;
use Hooloovoo\DataObjects\Field\Exception\InvalidValueException;

/**
 * Class FieldCollection
 */
class FieldCollection extends AbstractField
{
    const TYPE = 'array';

    /** @var DataObjectInterface[] */
    protected $_value;

    /**
     * @param DataObjectInterface[] $value
     */
    protected function _setValue($value = null)
    {
        if (!is_null($value) && !is_array($value)) {
            throw new InvalidValueException(self::class, $value);
        }

        foreach ($value as $member) {
            if (!$member instanceof DataObjectInterface) {
                throw new InvalidValueException(self::class, $value);
            }
        }

        $this->_value = $value;
    }

    /**
     * @return array
     */
    public function getSerialized()
    {
        $result = [];
        foreach ($this->_value as $dataObject) {
            $result[] = $dataObject->getSerialized();
        }

        return $result;
    }
}