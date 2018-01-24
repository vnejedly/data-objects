<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\DataObjectInterface;
use Hooloovoo\DataObjects\Field\Exception\InvalidValueException;

/**
 * Class FieldComputed
 */
class FieldComputed extends AbstractField
{
    /** @var DataObjectInterface */
    protected $dataObject;

    /** @var callable */
    protected $_value;

    /**
     * @param DataObjectInterface $dataObject
     */
    public function setParentDataObject(DataObjectInterface $dataObject)
    {
        $this->dataObject = $dataObject;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        $callback = &$this->_value;
        return $callback($this->dataObject);
    }

    /**
     * @return mixed
     */
    public function getSerialized()
    {
        return $this->getValue();
    }

    /**
     * @param callable $value
     */
    protected function _setValue($value = null)
    {
        if (is_null($value)) {
            $this->_value = function (DataObjectInterface $dataObject) {
                return null;
            };

            return;
        }

        if (!is_callable($value)) {
            throw new InvalidValueException(self::class, $value);
        }

        $this->_value = $value;
    }
}