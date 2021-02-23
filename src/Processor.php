<?php

namespace DevCoder;

class Processor
{
    public function resolveAsBoolean(string $boolean) : bool
    {
        return strtolower($boolean) === 'true';
    }

    public function isBoolean(string $value) : bool
    {
        $loweredValue = strtolower($value);

        return in_array($loweredValue, ['true', 'false'], true);
    }

    public function isWrappedByChar(string $value, string $char) : bool
    {
        return $value[0] === $char && $value[-1] === $char;
    }

    public function removeFirstAndLastChar(string $value) : string
    {
        /**
         * Since this function is used for the quote removal
         * we don't need mb_substr
         */
        return substr($value, 1, -1);
    }
}