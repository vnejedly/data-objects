<?php
use Hooloovoo\DataObjects\DataObjectInterface;

/**
 * @param mixed $data
 */
function dump_pre($data)
{
    echo "<pre>";
    dump($data);
    echo "</pre>";
}

/**
 * @param mixed $data
 */
function dump_pre_die($data)
{
    echo "<pre>";
    dump($data);
    echo "</pre>";
    die;
}

/**
 * @param mixed $data
 */
function dump_plain($data)
{
    dump($data);
}

/**
 * @param mixed $data
 */
function dump_plain_die($data)
{
    dump($data);
    die;
}

/**
 * @param mixed $data
 */
function dump($data)
{
    if (is_collection($data)) {
        dump_collection($data);
    } elseif ($data instanceof DataObjectInterface) {
        var_dump($data->getSerialized());
    } else {
        var_dump($data);
    }
}

/**
 * @param DataObjectInterface[] $collection
 */
function dump_collection(array $collection)
{
    foreach ($collection as $dataObject) {
        dump($dataObject);
    }
}

/**
 * @param mixed $data
 * @return bool
 */
function is_collection($data) : bool
{
    if (is_array($data)) {
        foreach ($data as $item) {
            if (!$item instanceof DataObjectInterface) {
                return false;
            }
        }

        return true;
    }

    return false;
}
