<?php
namespace Hooloovoo\DataObjects;

use Hooloovoo\DataObjects\Exception\LogicException;
use Hooloovoo\DataObjects\Field\FieldInterface;

/**
 * Class DataObject
 */
abstract class DataObject implements DataObjectInterface
{
    /** @var FieldInterface[] */
    protected $_fields;

    /**
     * @param DataObject $superclass
     */
    protected function _fetchSuperclassFields(self $superclass)
    {
        if (!is_subclass_of($this, get_class($superclass))) {
            throw new LogicException("Incompatible entities!");
        }

        foreach ($superclass->getFields() as $name => $field) {
            $this->_fields[$name] = $field;
        }
    }

    /**
     * @param string $fieldName
     * @return FieldInterface
     */
    public function __get(string $fieldName)
    {
        return $this->getField($fieldName)->getValue();
    }

    /**
     * @param $name
     * @return FieldInterface
     */
    public function getField($name)
    {
        if (!array_key_exists($name, $this->_fields)) {
            throw new LogicException("Field $name doesn't exist");
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
     * @param $name
     * @param FieldInterface $field
     */
    protected function _addField(string $name, FieldInterface $field)
    {
        $this->_fields[$name] = $field;
    }
}