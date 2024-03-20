<?php

namespace DevCoder\Processor;

class QuotedProcessor extends AbstractProcessor
{
    public function canBeProcessed(): bool
    {
        $wrappedByDoubleQuotes = $this->isWrappedByChar($this->value, '"');

        if ($wrappedByDoubleQuotes) {
            return true;
        }

        return $this->isWrappedByChar($this->value, '\'');
    }
    /**
     * Executes the function and returns a substring of the value property of the current object,
     * excluding the first and last characters.
     *
     * @return string The substring of the value property.
     */
    public function execute()
    {
        /**
         * Since this function is used for the quote removal
         * we don't need mb_substr
         */
        return substr($this->value, 1, -1);
    }

    private function isWrappedByChar(string $value, string $char) : bool
    {
        return !empty($value) && $value[0] === $char && $value[-1] === $char;
    }
}
