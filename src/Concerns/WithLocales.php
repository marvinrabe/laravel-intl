<?php

namespace MarvinRabe\LaravelIntl\Concerns;

trait WithLocales
{
    /**
     * The current locale.
     *
     * @var string $locale
     */
    protected $locale;

    /**
     * The current locale.
     *
     * @var string $locale
     */
    protected $fallbackLocale;

    /**
     * Get the current locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set the current locale.
     *
     * @param $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get the fallback locale.
     *
     * @return string
     */
    public function getFallbackLocale()
    {
        return $this->fallbackLocale;
    }

    /**
     * Set the fallback locale.
     *
     * @param $locale
     * @return $this
     */
    public function setFallbackLocale($locale)
    {
        $this->fallbackLocale = $locale;

        return $this;
    }
}
