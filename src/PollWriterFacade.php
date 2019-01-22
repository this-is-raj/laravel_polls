<?php
namespace Raj\LaravelPoll;

use Illuminate\Support\Facades\Facade;

class PollWriterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'pollwritter';
    }
}
