<?php
namespace Hooloovoo\DataObjects;

use Hooloovoo\DataObjects\Field\FieldInterface;

/**
 * Interface DataObjectInterface
 */
interface DataObjectInterface
{
    /**
     * @return bool
     */
    public function isUnlocked() : bool ;

    /**
     * @param $name
     * @return FieldInterface
     */
    public function getField($name);

    /**
     * @return FieldInterface[]
     */
    public function getFields();

    /**
     * @return array
     */
    public function getSerialized();
}