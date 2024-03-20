<?php
namespace DevCoder\Processor;

interface IProcessor
{
    public function __construct(string $value);

    /**
     * Check if the entity can be processed.
     *
     * @return bool
     */
    public function canBeProcessed(): bool;

    public function execute();
}
