<?php
namespace DevCoder\Processor;

abstract class AbstractProcessor implements IProcessor
{
    /**
     * The value to process
     * @var string
     */
    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}
