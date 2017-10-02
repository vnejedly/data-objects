<?php
namespace Hooloovoo\DataObjects\Field;

use Hooloovoo\DataObjects\DataObjectInterface;

/**
 * Class FieldCollection
 */
class FieldCollection extends AbstractField
{
    const TYPE = 'array';

    /** @var DataObjectInterface[] */
    protected $_value;

    /**
     * FieldCollection constructor.
     * @param DataObjectInterface[] $value
     */
    public function __construct(array $value = null)
    {
        $this->_value = $value;
    }

    /**
     * @param DataObjectInterface[] $value
     */
    public function setValue($value)
    {
        $this->_setValue($value);
    }

    /**
     * @param DataObjectInterface[] $value
     */
    protected function _setValue(array $value)
    {
        $this->_value = $value;
    }

    /**
     * @return array
     */
    public function getSerialized()
    {
        $result = [];
        foreach ($this->_value as $dataObject) {
            $result[] = $dataObject->getSerialized();
        }

        return $result;
    }
}