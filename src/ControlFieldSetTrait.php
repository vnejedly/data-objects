<?php
namespace Hooloovoo\DataObjects;

/**
 * Trait ControlFieldSetTrait
 */
trait ControlFieldSetTrait
{
    /** @var FieldSet[] */
    protected $controlFieldSets = [];

    /**
     * @param string $collectionName
     * @return FieldSet
     */
    public function getControlFieldSet(string $collectionName) : FieldSet
    {
        return $this->controlFieldSets[$collectionName];
    }

    /**
     * @param string $collectionName
     * @param FieldSet $fieldSet
     */
    protected function addControlFieldSet(string $collectionName, FieldSet $fieldSet)
    {
        $this->controlFieldSets[$collectionName] = $fieldSet;
    }
}