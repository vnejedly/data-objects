<?php
namespace Hooloovoo\DataObjects;

use Hooloovoo\DataObjects\Exception\LogicException;
use Hooloovoo\DataObjects\Field\FieldCollection;
use Hooloovoo\DataObjects\Field\FieldInterface;

/**
 * Class DataObject
 */
abstract class DataObject extends FieldSet implements DataObjectInterface
{
    const COLLECTION_SINGLE_PREFIX = 'single';

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
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $collectionSinglePrefix = self::COLLECTION_SINGLE_PREFIX;

        if (preg_match("/^$collectionSinglePrefix(\w+)$/", $name, $matches)) {
            $field = $this->getField(lcfirst($matches[1]));
            if ($field instanceof FieldCollection) {
                return $field->getSingle();
            }
        }

        return $this->getField($name)->getValue();
    }

    /**
     * @return bool
     */
    public function isUnlocked() : bool
    {
        foreach ($this->fields as $field) {
            if ($field->isUnlocked()) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * @return array
     */
    public function getSerialized() : array 
    {
        $result = [];
        foreach ($this->fields as $name => $field) {
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
            $this->fields[$name] = $field;
        }
    }
}