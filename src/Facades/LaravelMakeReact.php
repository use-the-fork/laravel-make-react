<?php

namespace UseTheFork\LaravelMakeReact\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \UseTheFork\LaravelMakeReact\LaravelMakeReact
 */
class LaravelMakeReact extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \UseTheFork\LaravelMakeReact\LaravelMakeReact::class;
    }
}
