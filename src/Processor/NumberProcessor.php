<?php
namespace DevCoder\Processor;

class NumberProcessor extends AbstractProcessor
{
    public function canBeProcessed(): bool
    {
        return is_numeric($this->value);
    }

    /**
     * Executes the function and returns an integer or float value based on the input.
     *
     * This function uses the `filter_var` function with the `FILTER_VALIDATE_INT` filter to check if the input value can be
     * converted to an integer. If the conversion is successful, the integer value is returned. Otherwise, the input value is
     * cast to a float and returned.
     *
     * @return int|float The converted integer or float value.
     */
    public function execute()
    {
        $int = filter_var($this->value, FILTER_VALIDATE_INT);

        if ($int !== false) {
            return $int;
        }

        return (float) $this->value;
    }
}
