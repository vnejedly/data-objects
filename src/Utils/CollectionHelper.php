<?php
namespace Hooloovoo\DataObjects\Utils;

use Hooloovoo\DataObjects\DataObjectInterface;
use Hooloovoo\DataObjects\Exception\NonExistingFieldValueException;
use Hooloovoo\DataObjects\Exception\NonExistingIndexException;

/**
 * Class CollectionHelper
 */
class CollectionHelper
{
    /** @var DataObjectInterface[] */
    protected $collection;

    /** @var string[] */
    protected $indexFields;

    /** @var DataObjectInterface[][][] */
    protected $index = [];

    /**
     * CollectionHelper constructor.
     * @param DataObjectInterface[] $collection
     * @param array $indexFields
     */
    public function __construct(array $collection, array $indexFields = [])
    {
        $this->collection = $collection;
        $this->indexFields = $indexFields;

        $this->createIndex($indexFields, $collection);
    }

    /**
     * @param string $fieldName
     * @return mixed[]
     */
    public function getFieldList(string $fieldName) : array
    {
        $fieldList = [];
        foreach ($this->collection as $object) {
            $fieldList[] = $object->getField($fieldName)->getValue();
        }

        return $fieldList;
    }

    /**
     * @param string $fieldName
     * @param mixed $fieldValue
     * @return DataObjectInterface
     * @throws NonExistingFieldValueException
     */
    public function getMemberByField(string $fieldName, $fieldValue) : DataObjectInterface
    {
        $subset = $this->getSubsetByField($fieldName, $fieldValue);

        if (0 == count($subset)) {
            throw new NonExistingFieldValueException($fieldName, $fieldValue);
        }

        return array_shift($subset);
    }

    /**
     * @param string $fieldName
     * @param mixed $fieldValue
     * @return DataObjectInterface[]
     * @throws NonExistingIndexException
     */
    public function getSubsetByField(string $fieldName, $fieldValue) : array
    {
        try {
            return $this->getSubsetByIndexedField($fieldName, $fieldValue);
        } catch (NonExistingIndexException $exception) {
            $subset = [];
            foreach ($this->collection as $dataObject) {
                $dataObjectHelper = new DataObjectHelper($dataObject);
                if ((string) $fieldValue == $dataObjectHelper->getField($fieldName)->getSerialized()) {
                    $subset[] = $dataObject;
                }
            }

            return $subset;
        }
    }

    /**
     * @param string $fieldName
     * @param mixed $fieldValue
     * @return DataObjectInterface[]
     */
    protected function getSubsetByIndexedField(string $fieldName, $fieldValue) : array
    {
        if (!array_key_exists($fieldName, $this->index)) {
            throw new NonExistingIndexException($fieldName);
        }

        if (!array_key_exists($fieldValue, $this->index[$fieldName])) {
            return [];
        }

        return $this->index[$fieldName][$fieldValue];
    }

    /**
     * @param array $fields
     * @param DataObjectInterface[] $collection
     */
    protected function createIndex(array $fields, array $collection)
    {
        foreach ($collection as $dataObject) {
            $dataObjectHelper = new DataObjectHelper($dataObject);
            foreach ($fields as $fieldName) {
                $indexString = $dataObjectHelper->getField($fieldName)->getSerialized();
                $this->index[$fieldName][$indexString][] = $dataObject;
            }
        }
    }
}