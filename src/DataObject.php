<?php
namespace Hooloovoo\DataObjects;

use Hooloovoo\DataObjects\Exception\LogicException;
use Hooloovoo\DataObjects\Field\FieldInterface;

/**
 * Class DataObject
 */
abstract class DataObject extends FieldSet implements DataObjectInterface
{
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
    public function getSerialized()
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

    /**
     * @param DataObjectInterface[] $collection
     * @param string $leadingFieldName
     * @param string $sourceFieldName
     * @param FieldSet $controlFieldSet
     * @param string $prefix
     */
    protected function transformCollection(
        array $collection,
        string $leadingFieldName,
        string $sourceFieldName,
        FieldSet $controlFieldSet = null,
        string $prefix = null
    ) {
        if (is_null($prefix)) {
            $prefix = $sourceFieldName;
        }

        foreach ($collection as $dataObject) {
            $leadingFieldValue = (string) $dataObject->getField($leadingFieldName)->getValue();
            $targetFieldName = $prefix . ucfirst($leadingFieldValue);
            $sourceField = $dataObject->getField($sourceFieldName);

            $this->addField($targetFieldName, $sourceField);

            if (!is_null($controlFieldSet)) {
                $controlFieldSet->addField($targetFieldName, $sourceField);
            }
        }
    }
}