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
     * @return string
     */
    public function getSerialized()
    {
        return $this->_value->getSerialized();
    }
}