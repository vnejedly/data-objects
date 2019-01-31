<?php
namespace Hooloovoo\DataObjects\Field;

/**
 * Interface ScalarFieldInterface
 */
interface ScalarFieldInterface extends FieldInterface
{
    /**
     * @return string
     */
    public function getStringValue() : ?string ;
}