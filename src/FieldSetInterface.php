<?php
namespace Hooloovoo\DataObjects;

use Hooloovoo\DataObjects\Field\FieldInterface;

/**
 * Interface FieldSetInterface
 */
interface FieldSetInterface
{
    /**
     * @param string $name
     * @return FieldInterface
     */
    public function getField(string $name) : FieldInterface;

    /**
     * @return FieldInterface[]
     */
    public function getFields() : array ;
}