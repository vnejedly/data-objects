<?php
namespace Hooloovoo\DataObjects\Field;

/**
 * Interface FieldInterface
 */
interface FieldInterface
{
    /**
     * @return mixed
     */
    public function getType();

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $value
     */
    public function setValue($value);

    /**
     * @return bool
     */
    public function isUnlocked() : bool ;

    /**
     * @return mixed
     */
    public function getSerialized();
}