<?php

namespace Laraveldevtools\Database;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Laraveldevtools\Database\Skeleton\SkeletonClass
 */
class DatabaseFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'database';
    }
}
