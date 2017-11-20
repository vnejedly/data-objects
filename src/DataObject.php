<?php
namespace Hooloovoo\DataObjects;

use Hooloovoo\DataObjects\Exception\LogicException;
use Hooloovoo\DataObjects\Exception\NonExistingFieldException;
use Hooloovoo\DataObjects\Field\FieldInterface;

/**
 * Class DataObject
 */
abstract class DataObject implements DataObjectInterface
{
    /** @var FieldInterface[] */
    protected $_fields;

    /** @var bool */
    protected $_unlocked = false;

    /**
     * @param string $fieldName
     * @return FieldInterface
     */
    public function __get(string $fieldName)
    {
        return $this->getField($fieldName)->getValue();
    }

    /**
     * @param string $fieldName
     * @param mixed $value
     */
    public function __set(string $fieldName, $value)
    {
        $this->getField($fieldName)->setValue($value);
        $this->_unlocked = true;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->getField($name)->getValue();
    }

    /**
     * @return bool
     */
    public function isUnlocked() : bool
    {
        return $this->_unlocked;
    }

    /**
     * @param $name
     * @return FieldInterface
     */
    public function getField($name)
    {
        if (!array_key_exists($name, $this->_fields)) {
            throw new NonExistingFieldException($name);
        }

        return $this->_fields[$name];
    }

    /**
     * @return FieldInterface[]
     */
    public function getFields()
    {
        return $this->_fields;
    }

    /**
     * @return array
     */
    public function getSerialized()
    {
        $result = [];
        foreach ($this->_fields as $name => $field) {
            $result[$name] = $field->getSerialized();
        }

        return $result;
    }

    /**
     * @param DataObjectInterface $superclass
     */
    protected function fetchSuperclassFields(DataObjectInterface $superclass)
    {
        if (!is_subclass_of($this, get_class($superclass))) {
            throw new LogicException("Incompatible entities!");
        }

        foreach ($superclass->getFields() as $name => $field) {
            $this->_fields[$name] = $field;
        }
    }

    /**
     * @param $name
     * @param FieldInterface $field
     */
    protected function addField(string $name, FieldInterface $field)
    {
        $this->_fields[$name] = $field;
    }
}