<?php

namespace Mycools\Eps\Facades;

use Illuminate\Support\Facades\Facade;

class Eps extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'eps';
    }
}
