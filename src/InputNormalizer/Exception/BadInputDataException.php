<?php
namespace Hooloovoo\DataObjects\InputNormalizer\Exception;

use Exception;
use Hooloovoo\DataObjects\Exception\RuntimeException;

/**
 * Class BadInputDataException
 */
class BadInputDataException extends RuntimeException
{
    /** @var string */
    protected $field;
    
    /** @var string */
    protected $pattern;
    
    /**
     * BadInputDataException constructor.
     * 
     * @param string $field
     * @param string $pattern
     * @param int $code
     * @param Exception $previous
     */
    public function __construct(
        string $field, 
        string $pattern,
        int $code = 0,
        Exception $previous = null
    ) {
        parent::__construct("Field $field must be set and match pattern $pattern", $code, $previous);
        $this->field = $field;
        $this->pattern = $pattern;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }
}