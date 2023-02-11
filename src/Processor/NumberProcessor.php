<?php
namespace DevCoder\Processor;

class NumberProcessor extends AbstractProcessor
{
    public function canBeProcessed(): bool
    {
        return is_numeric($this->value);
    }

    public function execute()
    {
        $int = filter_var($this->value, FILTER_VALIDATE_INT);

        if ($int !== false) {
            return $int;
        }

        return (float) $this->value;
    }
}
