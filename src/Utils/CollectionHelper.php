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

    /** @var DataObjectInterface[][][] */
    protected $index = [];

    /**
     * CollectionHelper constructor.
	 *
     * @param DataObjectInterface[] $collection
     */
    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

	/**
	 * @param string $fieldPath
	 */
	public function createIndex(string $fieldPath)
	{
		foreach ($this->collection as $dataObject) {
			$dataObjectHelper = new DataObjectHelper($dataObject);
			$indexString = $dataObjectHelper->getField($fieldPath)->getSerialized();
			$this->index[$fieldPath][$indexString][] = $dataObject;
		}
	}

	/**
	 * @param CollectionSorter $sorter
	 */
    public function sort(CollectionSorter $sorter)
	{
		$this->collection = $sorter->sortCollection($this->collection);
	}

	/**
	 * @return DataObjectInterface[]
	 */
	public function getCollection() : array
	{
		return $this->collection;
	}

    /**
     * @param string $fieldName
     * @return mixed[]
     */
    public function getFieldList(string $fieldName) : array
    {
		$fieldList = [];
		foreach ($this->collection as $object) {
			$helper = new DataObjectHelper($object);
			$fieldList[] = $helper->getField($fieldName)->getValue();
        }

        return $fieldList;
    }

	/**
	 * @param int $number
	 * @return DataObjectInterface
	 */
	public function getMember(int $number = 1) : DataObjectInterface
	{
		$index = 1;
		foreach ($this->collection as $member) {
			if ($number == $index) {
				return $member;
			}

			$index++;
		}
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

        foreach ($subset as $member) {
        	return $member;
		}
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
}