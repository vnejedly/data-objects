<?php
namespace Hooloovoo\DataObjects\Utils;

use Hooloovoo\DataObjects\DataObjectInterface;
use Hooloovoo\DataObjects\Field\FieldInterface;

/**
 * Class DataObjectHelper
 */
class DataObjectHelper
{
    /** @var DataObjectInterface */
    protected $dataObject;

    /** @var string */
    protected $plungeSeparator = '.';

    /**
     * DataObjectHelper constructor.
     *
     * @param DataObjectInterface $dataObject
     */
    public function __construct(DataObjectInterface $dataObject)
    {
        $this->dataObject = $dataObject;
    }

    /**
     * @return DataObjectInterface
     */
    public function getObject() : DataObjectInterface
    {
        return $this->dataObject;
    }

    /**
     * @param string $path
     * @return FieldInterface
     */
    public function getField(string $path) : FieldInterface
    {
        $parts = explode($this->plungeSeparator, $path);

        $field = null;
        $plunge = $this->dataObject;
        foreach ($parts as $part) {
            $field = $plunge->getField($part);
            $plunge = $field->getValue();
        }

        return $field;
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function getValue(string $path)
    {
        return $this->getField($path)->getValue();
    }

    /**
     * @param string $path
     * @return DataObjectHelper
     */
    public function getObjectHelper(string $path) : self
    {
        return new self($this->getValue($path));
    }

    /**
     * @param string $collectionPath
     * @param string $itemPath
     * @param bool $unique
     * @return array
     */
    public function getCollectionFieldValues(string $collectionPath, string $itemPath, bool $unique = false) : array
    {
        $collection = $this->getValue($collectionPath);

        $result = [];
        foreach ($collection as $object) {
            $helper = new self($object);
            $field = $helper->getField($itemPath);

            if ($unique) {
                $result[$field->getSerialized()] = $field->getValue();
            } else {
                $result[] = $field->getValue();
            }
        }

        return array_values($result);
    }

    /**
     * @param string $path
     * @param array $conditions
     * @return DataObjectInterface[]
     */
    public function getFilteredCollection(string $path, array $conditions) : array
    {
        $collection = $this->getValue($path);
        $filteredCollection = [];
        foreach ($collection as $dataObject) {
            $item = new self($dataObject);

            if ($this->passesConditions($item, $conditions)) {
                $filteredCollection[] = $dataObject;
            }
        }

        return $filteredCollection;
    }

    /**
     * @param string $path
     * @param array $conditions
     * @return DataObjectInterface
     */
    public function getCollectionItem(string $path, array $conditions)
    {
        $helper = $this->getCollectionItemHelper($path, $conditions);

        if (is_null($helper)) {
            return null;
        }

        return $helper->getObject();
    }

    /**
     * @param string $path
     * @param array $conditions
     * @return self
     */
    public function getCollectionItemHelper(string $path, array $conditions)
    {
        $collection = $this->getValue($path);
        foreach ($collection as $dataObject) {
            $item = new self($dataObject);

            if ($this->passesConditions($item, $conditions)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @param string $path
     * @param string $itemPath
     * @param array $conditions
     * @return FieldInterface
     */
    public function getCollectionItemField(string $path, string $itemPath, array $conditions)
    {
        $helper = $this->getCollectionItemHelper($path, $conditions);

        if (is_null($helper)) {
            return null;
        }

        return $helper->getField($itemPath);
    }

    /**
     * @param string $path
     * @param string $itemPath
     * @param array $conditions
     * @return mixed
     */
    public function getCollectionItemValue(string $path, string $itemPath, array $conditions)
    {
        $field = $this->getCollectionItemField($path, $itemPath, $conditions);

        if (is_null($field)) {
            return null;
        }

        return $field->getValue();
    }

    /**
     * @param string $collectionPath
     * @param string $itemPath
     * @return float
     */
    public function getCollectionFloatFieldSum(string $collectionPath, string $itemPath)
    {
        $values = $this->getCollectionFieldValues($collectionPath, $itemPath, false);

        $sum = (float) 0;
        foreach ($values as $value) {
            if (!is_numeric($value)) {
                return null;
            }

            $sum = $sum + (float) $value;
        }

        return (float) $sum;
    }

    /**
     * @param string $collectionPath
     * @param string $itemPath
     * @return int
     */
    public function getCollectionIntegerFieldSum(string $collectionPath, string $itemPath)
    {
        $values = $this->getCollectionFieldValues($collectionPath, $itemPath, false);

        $sum = (int) 0;
        foreach ($values as $value) {
            if (!is_numeric($value)) {
                return null;
            }

            $sum = $sum + (int) $value;
        }

        return (int) $sum;
    }

    /**
     * @param DataObjectHelper $item
     * @param array $conditions
     * @return bool
     */
    protected function passesConditions(self $item, array $conditions) : bool
    {
        foreach ($conditions as $columnName => $columnValue) {
            $current = $item->getValue($columnName);

            if (
                (is_array($columnValue) && !$this->compareArray($current, $columnValue)) ||
                (!is_array($columnValue) && !$this->compareSingle($current, $columnValue))
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param mixed $current
     * @param mixed[] $expected
     * @return bool
     */
    protected function compareArray($current, array $expected) : bool
    {
        $passed = false;
        foreach ($expected as $exp) {
            if ($exp == $current) {
                $passed = true;
            }
        }

        return $passed;
    }

    /**
     * @param mixed $current
     * @param mixed $expected
     * @return bool
     */
    protected function compareSingle($current, $expected) : bool
    {
        return $current == $expected;
    }
}