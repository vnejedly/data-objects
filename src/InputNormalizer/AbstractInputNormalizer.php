<?php
namespace Hooloovoo\DataObjects\InputNormalizer;

use Hooloovoo\DataObjects\InputNormalizer\Exception\BadInputDataException;
use Hooloovoo\DataObjects\DataObjectInterface;

/**
 * Class AbstractInputNormalizer
 */
abstract class AbstractInputNormalizer implements NormalizerInterface
{
    const PATTERN = 1;
    const REQUIRED = 2;
    const CALLBACK_VALUE = 3;

    /** @var array[] */
    protected $fields = [];

    /** @var array[] */
    protected $conditionedFields = [];

    /**
     * AbstractInputNormalizer constructor.
     */
    public function __construct()
    {
        $this->setUp();
    }

    /**
     * @param array $data
     * @return array
     */
    public function getNormalizedData(array $data) : array 
    {
        return array_merge(
            $this->getNormalizedSimpleFields($data),
            $this->getNormalizedConditionedFields($data)
        );
    }

    /**
     * @param string $fieldName
     * @param string $pattern
     * @param bool $required
     * @param callable $valueCallback
     */
    protected function addField(string $fieldName, string $pattern, bool $required, callable $valueCallback = null)
    {
        $this->fields[$fieldName] = [
            self::PATTERN => $pattern,
            self::REQUIRED => $required,
            self::CALLBACK_VALUE => $valueCallback,
        ];
    }

    /**
     * @param string $fieldName
     * @param string $pattern
     * @param callable $requiredIfCallback
     * @param callable $valueCallback
     */
    protected function addConditionedField(
        string $fieldName, 
        string $pattern, 
        callable $requiredIfCallback, 
        callable $valueCallback = null
    ) {
        $this->conditionedFields[$fieldName] = [
            self::PATTERN => $pattern,
            self::REQUIRED => $requiredIfCallback,
            self::CALLBACK_VALUE => $valueCallback,
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    protected function getNormalizedSimpleFields(array $data) : array
    {
        $outputData = [];
        foreach ($this->fields as $fieldName => $field) {
            $pattern = $field[self::PATTERN];
            $required = $field[self::REQUIRED];
            $valueCallBack = $field[self::CALLBACK_VALUE];
            
            $this->resolveField($fieldName, $pattern, $required, $data, $outputData, $valueCallBack);
        }

        return $outputData;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function getNormalizedConditionedFields(array $data) : array 
    {
        $outputData = [];
        foreach ($this->conditionedFields as $fieldName => $field) {
            $pattern = $field[self::PATTERN];
            $required = (bool) $field[self::REQUIRED]($data);
            $valueCallBack = $field[self::CALLBACK_VALUE];

            $this->resolveField($fieldName, $pattern, $required, $data, $outputData, $valueCallBack);
        }
        
        return $outputData;
    }

    /**
     * @param string $fieldName
     * @param string $pattern
     * @param bool $required
     * @param array $data
     * @param array $outputData
     * @param callable $valueCallback
     */
    protected function resolveField(
        string $fieldName, 
        string $pattern, 
        bool $required, 
        array $data, 
        array &$outputData,
        callable $valueCallback = null
    ) {
        $pattern = "/^$pattern$/";
        
        if (is_null($valueCallback)) {
            $valueCallback = function ($value) {
                return $value;
            };
        }
        
        if ($required) {
            if (!array_key_exists($fieldName, $data) || !preg_match($pattern, $data[$fieldName])) {
                throw new BadInputDataException($fieldName, $pattern);
            }

            $outputData[$fieldName] = $valueCallback($data[$fieldName]);
        } elseif (array_key_exists($fieldName, $data) && !is_null($data[$fieldName])) {
            if (!preg_match($pattern, $data[$fieldName])) {
                throw new BadInputDataException($fieldName, $pattern);
            }

            $outputData[$fieldName] = $valueCallback($data[$fieldName]);
        }
    }

    /**
     * @param DataObjectInterface $entity
     * @param array $data
     * @return DataObjectInterface
     */
    protected function fillEntity(DataObjectInterface $entity, array $data) : DataObjectInterface
    {
        $normalizedData = $this->getNormalizedData($data);

        foreach ($normalizedData as $name => $value) {
            $entity->getField($name)->setValue($value);
        }
        
        return $entity;
    }

    /**
     * Setup all patterns here
     */
    abstract protected function setUp();
}