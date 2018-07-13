<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\DataObjectInterface;
use Hooloovoo\ORM\Exception\ComputedFieldUnsettableException;
use Hooloovoo\ORM\Exception\InvalidCallbackException;

/**
 * Class FieldComputed
 */
class FieldComputed extends AbstractField
{
    /** @var DataObjectInterface */
    protected $dataObject;

    /** @var callable */
    protected $callbackSet;

    /** @var callable */
    protected $callbackGet;

    /**
     * FieldComputed constructor.
     *
     * @param callable $callbackGet
     * @param callable|null $callbackSet
     */
    public function __construct(callable $callbackGet, callable $callbackSet = null)
    {
        if (is_null($callbackSet)) {
            $callbackSet = function (DataObjectInterface $dataObject, $value) {
                throw new ComputedFieldUnsettableException(get_class($dataObject), $value);
            };
        }

        if (!is_callable($callbackGet) || !is_callable($callbackSet)) {
            throw new InvalidCallbackException();
        }

        $this->callbackGet = $callbackGet;
        $this->callbackSet = $callbackSet;
    }

    /**
     * @param DataObjectInterface $dataObject
     */
    public function setParentDataObject(DataObjectInterface $dataObject)
    {
        $this->dataObject = $dataObject;
    }

    /**
     * @return mixed
     */
    public function getSerialized()
    {
        return $this->getValue();
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        $callback = &$this->callbackGet;
        return $callback($this->dataObject);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    protected function _setValue($value = null)
    {
        $callback = &$this->callbackSet;
        $callback($value, $this->dataObject);
    }
}