<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\ValueObjects;

use InvalidArgumentException;
use OtherCode\ComplexHeart\Domain\IsValueObject;

/**
 * Class StringValueObject
 *
 * @method string value()
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\ValueObjects
 */
abstract class StringValue
{
    use IsValueObject;

    /**
     * Check the min length or the string.
     *
     * @var int
     */
    protected int $_minLength = 0;

    /**
     * Check the max length of the string.
     *
     * @var int
     */
    protected int $_maxLength = 0;

    /**
     * The pattern to match for the given string.
     *
     * @var string
     */
    protected string $_pattern = '';

    /**
     * The value storage.
     *
     * @var string
     */
    private string $value;

    /**
     * StringValue constructor.
     *
     * @param  string  $value
     */
    public function __construct(string $value)
    {
        $this->initialize(['value' => $value]);
    }

    protected function invariantValueMinLengthMustBeValid(): bool
    {
        $length = strlen($this->value);
        if ($this->_minLength > 0 && $length < $this->_minLength) {
            throw new InvalidArgumentException(
                "Min length {$this->_minLength} is required, given {$length}"
            );
        }

        return true;
    }

    protected function invariantValueMaxLengthMustBeValid(): bool
    {
        $length = strlen($this->value);
        if ($this->_maxLength > 0 && $length > $this->_maxLength) {
            throw new InvalidArgumentException(
                "Max length {$this->_maxLength} exceeded, given {$length}"
            );
        }

        return true;
    }

    protected function invariantValueMustMatchRegexPattern(): bool
    {
        if (!empty($this->_pattern)
            && preg_match($this->_pattern, $this->value) !== 1
        ) {
            throw new InvalidArgumentException(
                "Invalid value, does not match pattern {$this->_pattern}"
            );
        }

        return true;
    }

    /**
     * To string method... string is a string...
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
