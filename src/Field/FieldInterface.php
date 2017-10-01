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
     * @return mixed
     */
    public function getSerialized();
}