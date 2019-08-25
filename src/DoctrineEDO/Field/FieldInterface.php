<?php
namespace Hooloovoo\DataObjects\DoctrineEDO\Field;

use Hooloovoo\DataObjects\Field\FieldInterface as GenericInterface;

/**
 * Interface FieldInterface
 */
interface FieldInterface extends GenericInterface
{
    /**
     * @param $referancedVariable
     * @param callable $valueSetHandler
     * @param callable $valueGetHandler
     */
    public function initValueReference(
        &$referancedVariable, 
        callable $valueSetHandler, 
        callable $valueGetHandler
    );
}