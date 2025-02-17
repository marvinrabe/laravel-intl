<?php namespace MarvinRabe\LaravelIntl\Facades;

use Illuminate\Support\Facades\Facade;

class Country extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'intl.country';
    }
}
