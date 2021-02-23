<?php

namespace DevCoder;

class Option
{
    /**
     * Convert true and false to booleans, instead of:
     *
     * VARIABLE=false -> ['VARIABLE' => 'false']
     *
     * it will be
     *
     * VARIABLE=false -> ['VARIABLE' => false]
     *
     * default = true
     */
    const PROCESS_BOOLEANS = 'PROCESS_BOOLEANS';

    /**
     * Remove double and single quotes at the start and end of the variables, instead of:
     *
     * VARIABLE="This is a "sample" value" -> ['VARIABLE' => '"This is a "sample" value"']
     *
     * it will be
     *
     * VARIABLE="This is a "sample" value" -> ['VARIABLE' => 'This is a "sample" value']
     *
     * default = true
     */
    const PROCESS_QUOTES = 'PROCESS_QUOTES';
}