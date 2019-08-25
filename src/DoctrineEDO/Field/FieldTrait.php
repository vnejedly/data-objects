<?php
namespace Hooloovoo\DataObjects\DoctrineEDO\Field;

/**
 * Trait FieldTrait
 */
trait FieldTrait
{
    /** @var mixed */
    protected $_value;

    /** @var callable */
    protected $valueSetHandler;

    /** @var callable */
    protected $valueGetHandler;

    /**
     * FieldTrait constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $referancedVariable
     * @param callable $valueSetHandler
     * @param callable $valueGetHandler
     */
    public function initValueReference(
        &$referancedVariable,
        callable $valueSetHandler,
        callable $valueGetHandler
    )
    {
        $this->_value = &$referancedVariable;
        $this->valueSetHandler = $valueSetHandler;
        $this->valueGetHandler = $valueGetHandler;
    }

    public function getValue()
    {
        $callback = &$this->valueGetHandler;
        return $callback(parent::getValue());
    }

    /**
     * @param mixed $value
     */
    protected function _setValue($value = null)
    {
        $callback = &$this->valueSetHandler;
        parent::_setValue($callback($value));
    }
}