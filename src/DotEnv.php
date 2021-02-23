<?php

namespace DevCoder;

class DotEnv
{
    /**
     * The directory where the .env file can be located.
     *
     * @var string
     */
    protected $path;

    /**
     * Configure the options on which the parsed will act
     *
     * @var array
     */
    protected $options = [];

    /**
     * Process strings to obtain characteristics of it
     *
     * @var Processor
     */
    protected $processor;

    public function __construct(string $path, array $options = [])
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $path));
        }

        $this->path = $path;

        $this->processOptions($options);

        $this->processor = new Processor();
    }

    private function processOptions(array $options) : void
    {
        $this->options = array_merge([
            Option::PROCESS_BOOLEANS => true,
            Option::PROCESS_QUOTES => true
        ], $options);
    }

    /**
     * Processes the $path of the instances and parses the values into $_SERVER and $_ENV, also returns all the data that has been read.
     * Skips empty and commented lines.
     */
    public function load() : void
    {
        if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('%s file is not readable', $this->path));
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

    private function processValue(string $value)
    {
        /**
         * First trim spaces and quotes if configured
         */
        $preprocessedValue = $this->preprocessValue($value);

        /**
         * If the value is a boolean resolve it as such
         */
        if (!empty($this->options[Option::PROCESS_BOOLEANS])) {
            $isBoolean = $this->processor->isBoolean($preprocessedValue);

            if ($isBoolean) {
                return $this->processor->resolveAsBoolean($preprocessedValue);
            }
        }

        /**
         * Does not match any processor options, return as is
         */
        return $preprocessedValue;
    }

    private function preprocessValue(string $value) : string
    {
        $trimmedValue = trim($value);

        if (!empty($this->options[Option::PROCESS_QUOTES])) {
            $wrappedBySingleQuotes = $this->processor->isWrappedByChar($trimmedValue, '\'');
            $wrappedByDoubleQuotes = $this->processor->isWrappedByChar($trimmedValue, '"');

            if ($wrappedBySingleQuotes || $wrappedByDoubleQuotes) {
                return $this->processor->removeFirstAndLastChar($trimmedValue);
            }
        }

        return $trimmedValue;
    }
}
