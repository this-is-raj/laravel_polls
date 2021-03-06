<?php

namespace Raj\LaravelPoll\Exceptions;

use Exception;

class OptionsInvalidNumberProvidedException extends Exception
{
    /**
     * Create a new instance
     */
    public function __construct()
    {
        parent::__construct('You can not create poll with one option');
    }
}
