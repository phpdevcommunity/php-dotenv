<?php
namespace DevCoder\Processor;

class BooleanProcessor extends AbstractProcessor
{
    public function canBeProcessed(): bool
    {
        $loweredValue = strtolower($this->value);

        return in_array($loweredValue, ['true', 'false'], true);
    }

    /**
     * Executes the PHP function and returns a boolean value indicating whether the value is 'true' in lowercase.
     *
     * @return bool The result of the comparison between the lowercase value of $this->value and 'true'.
     */
    public function execute()
    {
        return strtolower($this->value) === 'true';
    }
}
