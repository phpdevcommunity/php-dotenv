<?php

namespace DevCoder;

use DevCoder\Processor\AbstractProcessor;
use DevCoder\Processor\BooleanProcessor;
use DevCoder\Processor\NullProcessor;
use DevCoder\Processor\NumberProcessor;
use DevCoder\Processor\QuotedProcessor;
use InvalidArgumentException;
use RuntimeException;

class DotEnv
{
    /**
     * The directory where the .env file can be located.
     *
     * @var string
     */
    protected string $path;

    /**
     * Configure the options on which the parsed will act
     *
     * @var string[]
     */
    protected array $processors = [];

    public function __construct(string $path, array $processors = null)
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException(sprintf('%s does not exist', $path));
        }

        $this->path = $path;

        $this->setProcessors($processors);
    }

    /**
     * Loads the configuration data from the specified file path.
     * Parses the values into $_SERVER and $_ENV arrays, skipping empty and commented lines.
     */
    public function load(): void
    {
        if (!is_readable($this->path)) {
            throw new RuntimeException(sprintf('%s file is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {

            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = $this->processValue($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }

    private function setProcessors(array $processors = null): void
    {
        /**
         * Fill with default processors
         */
        if ($processors === null) {
            $this->processors = [
                NullProcessor::class,
                BooleanProcessor::class,
                NumberProcessor::class,
                QuotedProcessor::class
            ];
            return;
        }

        foreach ($processors as $processor) {
            if (is_subclass_of($processor, AbstractProcessor::class)) {
                $this->processors[] = $processor;
            }
        }
    }


    /**
     * Process the value with the configured processors
     *
     * @param string $value The value to process
     * @return mixed
     */
    private function processValue(string $value)
    {
        /**
         * First trim spaces and quotes if configured
         */
        $trimmedValue = trim($value);

        foreach ($this->processors as $processor) {
            /** @var AbstractProcessor $processorInstance */
            $processorInstance = new $processor($trimmedValue);

            if ($processorInstance->canBeProcessed()) {
                return $processorInstance->execute();
            }
        }

        /**
         * Does not match any processor options, return as is
         */
        return $trimmedValue;
    }
}
