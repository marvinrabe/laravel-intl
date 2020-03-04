<?php

use Illuminate\Support\Facades\Date;

if (! function_exists('country')) {
    /**
     * Get a localized country name.
     *
     * @param string|null $countryCode
     * @return \MarvinRabe\LaravelIntl\Country|string
     */
    function country($countryCode = null)
    {
        if (is_null($countryCode)) {
            return app('intl.country');
        }

        return app('intl.country')->name($countryCode);
    }
}

if (! function_exists('currency')) {
    /**
     * Get a localized currency or currency amount.
     *
     * @return \MarvinRabe\LaravelIntl\Currency|string
     */
    function currency()
    {
        $arguments = func_get_args();

        if (count($arguments) === 0) {
            return app('intl.currency');
        }

        if (count($arguments) > 0 && is_numeric($arguments[0])) {
            return app('intl.currency')->format(...$arguments);
        }

        return app('intl.currency')->name(...$arguments);
    }
}

if (! function_exists('carbon')) {
    /**
     * Get a localized Carbon instance.
     *
     * @param  string $time
     * @param  string|DateTimeZone $timezone
     * @return \Illuminate\Support\DateFactory|string
     */
    function carbon($time = null, $timezone = null)
    {
        return Date::make($time, $timezone);
    }
}

if (! function_exists('language')) {
    /**
     * Get a localized language name.
     *
     * @param string|null $langCode
     * @return \MarvinRabe\LaravelIntl\Language|string
     */
    function language($langCode = null)
    {
        if (is_null($langCode)) {
            return app('intl.language');
        }

        return app('intl.language')->name($langCode);
    }
}

if (! function_exists('number')) {
    /**
     * Get a formatted localized number.
     *
     * @param string|int|float|null $number
     * @param array $options
     * @return \MarvinRabe\LaravelIntl\Number|string
     */
    function number($number = null, $options = [])
    {
        if (is_null($number)) {
            return app('intl.number');
        }

        return app('intl.number')->format($number, $options);
    }
}
