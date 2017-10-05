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
     * @param DataObjectInterface[] $value
     */
    public function setValue($value)
    {
        $this->_setValue($value);
    }

    /**
     * @param DataObjectInterface[] $value
     */
    protected function _setValue(array $value = null)
    {
        if (is_null($value)) {
            $value = [];
        }

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