<?php
namespace Hooloovoo\DataObjects;

use Hooloovoo\DataObjects\Field\FieldComputed;

/**
 * Class FieldSet
 */
class FieldSet
{
    /** @var FieldComputed[] */
    protected $fields = [];

    /**
     * @param string $name
     * @param FieldComputed $field
     */
    public function addField(string $name, FieldComputed $field)
    {
        $this->fields[$name] = $field;
    }

    /**
     * @return FieldComputed[]
     */
    public function getFields() : array
    {
        return $this->fields;
    }
}