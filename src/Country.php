<?php

namespace MarvinRabe\LaravelIntl;

use Illuminate\Support\Arr;
use MarvinRabe\LaravelIntl\Concerns\WithLocales;
use MarvinRabe\LaravelIntl\Contracts\Intl;

class Country extends Intl
{
    use WithLocales;

    /**
     * Loaded localized country data.
     *
     * @var array
     */
    protected $data;

    /**
     * Get a localized record by key.
     *
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        return Arr::get($this->all(), $key);
    }

    /**
     * Alias of get().
     *
     * @param string $key
     * @return string
     */
    public function name($key)
    {
        return $this->get($key);
    }

    /**
     * Get all localized records.
     *
     * @return array
     */
    public function all()
    {
        $default = $this->data($this->getLocale());
        $fallback = $this->data($this->getFallbackLocale());

        return $default + $fallback;
    }

    /**
     * Get the data for the given locale.
     *
     * @param string $locale
     * @return array
     */
    protected function data($locale)
    {
        if (! isset($this->data[$locale])) {
            $path = base_path('vendor/umpirsky/country-list/data/'.$locale.'/country.php');

            $this->data[$locale] = is_file($path) ? require $path : [];
        }

        return $this->data[$locale];
    }
}
