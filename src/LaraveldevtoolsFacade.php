<?php

namespace Laraveldevtools\Laraveldevtools;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Laraveldevtools\Laraveldevtools\LaraveldevtoolsClass
 */
class LaraveldevtoolsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laraveldevtools';
    }
}
