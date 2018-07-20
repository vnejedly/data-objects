<?php
namespace Hooloovoo\DataObjects;

/**
 * Interface DataObjectInterface
 */
interface DataObjectInterface extends FieldSetInterface
{
    /**
     * @return bool
     */
    public function isUnlocked() : bool ;

    /**
     * @return array
     */
    public function getSerialized();
}