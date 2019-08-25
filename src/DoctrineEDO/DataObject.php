<?php
namespace Hooloovoo\DataObjects\DoctrineEDO;

use Doctrine\ORM\Mapping as ORM;
use Hooloovoo\DataObjects\DataObjectInterface;
use Hooloovoo\DataObjects\Field\FieldInterface;
use Hooloovoo\DataObjects\DoctrineEDO\Field\FieldInterface as FieldInterfaceEDO;

/**
 * Class AbstractEntity
 */
class DataObject implements DataObjectInterface
{
    /** @var FieldInterfaceEDO[] */
    private $_fields = [];
    
    /** @var bool */
    private $_initialized = false;
    
    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->getField($name)->getValue();
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->getField($name)->setValue($value);
    }

    /**
     * @param string $name
     * @param mixed $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (preg_match('/^set([A-Z].*)/', $name, $matches)) {
            $name = lcfirst($matches[1]);
            $this->getField($name)->setValue($arguments[0]);
            return null;
        }

        if (preg_match('/^get([A-Z].*)/', $name, $matches)) {
            $name = lcfirst($matches[1]);
        }

        return $this->getField($name)->getValue();
    }

    /**
     * @return array
     */
    public function getSerialized() : array
    {
        $result = [];
        foreach ($this->getFields() as $name => $field) {
            dump(get_class($this));
            dump(get_class($field));
            dump($name);
            $result[$name] = $field->getSerialized();
        }

        return $result;
    }

    /**
     * @param string $name
     * @return FieldInterface
     */
    public function getField(string $name) : FieldInterface
    {
        $this->initOnce();
        return $this->_fields[$name];
    }

    /**
     * @return FieldInterface[]
     */
    public function getFields() : array
    {
        $this->initOnce();
        return $this->_fields;
    }

    /**
     * @return bool
     */
    public function isUnlocked() : bool
    {
        return true;
    }

    /**
     * @param string $name
     * @param FieldInterfaceEDO $field
     */
    protected function addField(string $name, FieldInterfaceEDO $field)
    {
        $field->initValueReference(
            $this->$name,
            $this->getValueHandler('handleSet', $name),
            $this->getValueHandler('handleGet', $name)
        );

        $this->_fields[$name] = $field;
    }

    /**
     * To be called before any prerty manipulation
     */
    protected function initOnce()
    {
        if ($this->_initialized) {
            return;
        }

        $this->init();
        $this->_initialized = true;
    }

    /**
     * @param string $fieldName
     * @return callable
     */
    protected function getValueHandler(string $prefix, string $fieldName) : callable
    {
        $handlerName = $prefix . ucfirst($fieldName);
        if (method_exists($this, $handlerName)) {
            return function ($value) use ($handlerName) {
                return $this->{$handlerName}($value);
            };
        } else {
            return function ($value) {
                return $value;
            };
        }
    }

    /** To be implemented by extension */
    protected function init() {}
}