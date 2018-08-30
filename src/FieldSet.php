<?php
namespace Hooloovoo\DataObjects;

use Hooloovoo\DataObjects\Exception\NonExistingFieldException;
use Hooloovoo\DataObjects\Field\FieldComputed;
use Hooloovoo\DataObjects\Field\FieldInterface;

/**
 * Class FieldSet
 */
class FieldSet implements FieldSetInterface
{
    /** @var FieldComputed[] */
    protected $fields = [];

    /** @var self[] */
    protected $controlFieldSets = [];

    /**
     * @param $name
     * @param FieldInterface $field
     */
    public function addField(string $name, FieldInterface $field)
    {
        if ($field instanceof FieldComputed) {
            $field->setFieldSet($this);
        }

        $this->fields[$name] = $field;
    }

    /**
     * @param $name
     * @return FieldInterface
     */
    public function getField(string $name) : FieldInterface
    {
        if (!array_key_exists($name, $this->fields)) {
            throw new NonExistingFieldException($name);
        }

        return $this->fields[$name];
    }

    /**
     * @return FieldComputed[]
     */
    public function getFields() : array
    {
        return $this->fields;
    }

    /**
     * @param string $name
     * @return FieldSet
     */
    public function getControlFieldSet(string $name) : self
    {
        return $this->controlFieldSets[$name];
    }

    /**
     * @param DataObjectInterface[] $collection
     * @param string $leadingFieldName
     * @param string $sourceFieldName
     * @param string $prefix
     */
    protected function transformCollection(
        array $collection,
        string $leadingFieldName,
        string $sourceFieldName,
        string $prefix = null
    ) {
        if (is_null($prefix)) {
            $prefix = $sourceFieldName;
        }

        $this->addControlFieldSet($prefix, $controlFieldSet = new self());

        foreach ($collection as $dataObject) {
            $leadingFieldValue = (string) $dataObject->getField($leadingFieldName)->getValue();
            $targetFieldName = $prefix . ucfirst($leadingFieldValue);
            $sourceField = $dataObject->getField($sourceFieldName);

            $this->addField($targetFieldName, $sourceField);
            $controlFieldSet->addField($targetFieldName, $sourceField);
        }
    }

    /**
     * @param string $name
     * @param FieldSet $fieldSet
     */
    protected function addControlFieldSet(string $name, self $fieldSet)
    {
        $this->controlFieldSets[$name] = $fieldSet;
    }
}