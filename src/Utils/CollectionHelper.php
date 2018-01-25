<?php
namespace Hooloovoo\DataObjects\Utils;

use Hooloovoo\DataObjects\DataObjectInterface;

/**
 * Class CollectionHelper
 */
class CollectionHelper
{
    /** @var DataObjectInterface[] */
    protected $collection;

    /**
     * CollectionHelper constructor.
     * @param DataObjectInterface[] $collection
     */
    public function __construct(array $collection)
    {
        $this->collection = $collection;
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
}