<?php
namespace Hooloovoo\DataObjects\Utils;

use Hooloovoo\DataObjects\DataObjectInterface;

/**
 * Class CollectionSorter
 */
class CollectionSorter
{
    const FIELD_PATH = 'path';
    const DIRECTION = 'direction';

    /** @var bool[] */
    protected $fields = [];

    /**
     * @param string $fieldPath
     * @param bool $direction
     */
    public function addOrder(string $fieldPath, bool $direction)
    {
        $this->fields[] = [
            static::FIELD_PATH => $fieldPath,
            static::DIRECTION => $direction,
        ];
    }

    /**
     * @param DataObjectInterface[] $collection
     * @return DataObjectInterface[]
     */
    public function sortCollection(array $collection) : array
    {
        $sortedCollection = $collection;

        usort(
            $sortedCollection,
            function (DataObjectInterface $itemA, DataObjectInterface $itemB) {
                return $this->compareObjects(new DataObjectHelper($itemA), new DataObjectHelper($itemB));
            }
        );

        return $sortedCollection;
    }

    /**
     * @param DataObjectHelper[] $collection
     * @return DataObjectHelper[]
     */
    public function sortHelperCollection(array $collection) : array
    {
        $sortedCollection = $collection;

        usort(
            $sortedCollection,
            function (DataObjectHelper $itemA, DataObjectHelper $itemB) {
                return $this->compareObjects($itemA, $itemB);
            }
        );

        return $sortedCollection;
    }

    /**
     * @param DataObjectHelper $helperA
     * @param DataObjectHelper $helperB
     * @return int
     */
    protected function compareObjects(DataObjectHelper $helperA, DataObjectHelper $helperB) : int
    {
        foreach ($this->fields as $fieldOrder) {
            $fieldA = $helperA->getField($fieldOrder[static::FIELD_PATH]);
            $fieldB = $helperB->getField($fieldOrder[static::FIELD_PATH]);

            $compValue = $fieldA->compareWith($fieldB, $fieldOrder[static::DIRECTION]);

            if ($compValue < 0 || $compValue > 0) {
                return $compValue;
            }
        }

        return 0;
    }
}