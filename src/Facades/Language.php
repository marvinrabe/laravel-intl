<?php namespace MarvinRabe\LaravelIntl\Facades;

use Illuminate\Support\Facades\Facade;

class Language extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'intl.language';
    }
}
