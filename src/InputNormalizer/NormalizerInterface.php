<?php
namespace Hooloovoo\DataObjects\InputNormalizer;
use Hooloovoo\DataObjects\DataObjectInterface;

/**
 * Interface NormalizerInterface
 */
interface NormalizerInterface
{
    /**
     * @param array $data
     * @return array
     */
    public function getNormalizedData(array $data) : array;

    /**
     * @param array $data
     * @return DataObjectInterface
     */
    public function getEntity(array $data) : DataObjectInterface;
}