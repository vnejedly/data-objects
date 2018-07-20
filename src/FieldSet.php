<?php
namespace Hooloovoo\DataObjects;

use Hooloovoo\DataObjects\Exception\NonExistingFieldException;
use Hooloovoo\DataObjects\Field\FieldComputed;
use Hooloovoo\DataObjects\Field\FieldInterface;

/**
 * Class FieldSet
 */
class FieldSet implements FieldSetInterface
{
    /** @var FieldComputed[] */
    protected $fields = [];

    /**
     * @param $name
     * @param FieldInterface $field
     */
    public function addField(string $name, FieldInterface $field)
    {
        if ($field instanceof FieldComputed) {
            $field->setFieldSet($this);
        }

        $this->fields[$name] = $field;
    }

    /**
     * @param $name
     * @return FieldInterface
     */
    public function getField(string $name) : FieldInterface
    {
        if (!array_key_exists($name, $this->fields)) {
            throw new NonExistingFieldException($name);
        }

        return $this->fields[$name];
    }

    /**
     * @return FieldComputed[]
     */
    public function getFields() : array
    {
        return $this->fields;
    }
}