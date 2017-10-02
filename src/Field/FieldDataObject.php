<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\DataObjectInterface;

/**
 * Class FieldDataObject
 */
class FieldDataObject extends AbstractField
{
    const TYPE = DataObjectInterface::class;

    /** @var DataObjectInterface */
    protected $_value;

    /**
     * FieldDataObject constructor.
     * @param DataObjectInterface $value
     */
    public function __construct(DataObjectInterface $value = null)
    {
        $this->_value = $value;
    }

    /**
     * @param DataObjectInterface $value
     */
    public function setValue($value)
    {
        $this->_setValue($value);
    }

    /**
     * @param DataObjectInterface $value
     */
    protected function _setValue(DataObjectInterface $value)
    {
        $this->_value = $value;
    }

    /**
     * @return array
     */
    public function getSerialized()
    {
        return $this->_value->getSerialized();
    }
}