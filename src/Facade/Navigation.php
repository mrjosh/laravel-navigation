<?php

namespace Josh\Components\Navigation\Facade;

use Illuminate\Support\Facades\Facade;
use Josh\Components\Navigation\Collection;

/**
 * @see \Josh\Components\Navigation\Navigation
 *
 * @method static group($name,\Closure $callback)
 * @method static register($name,\Closure $callback = null)
 * @method static Collection getCollection($name)
 * @method static array getCollections()
 */
class Navigation extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'navbar';
    }
}