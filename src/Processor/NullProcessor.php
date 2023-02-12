<?php
namespace DevCoder\Processor;

class NullProcessor extends AbstractProcessor
{
    public function canBeProcessed(): bool
    {
        return in_array($this->value, ['null', 'NULL'], true);
    }

    public function execute()
    {
        return null;
    }
}
