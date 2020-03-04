<?php

namespace MarvinRabe\LaravelIntl;

use CommerceGuys\Intl\Formatter\NumberFormatter;
use CommerceGuys\Intl\NumberFormat\NumberFormatRepository;
use Illuminate\Support\Arr;
use MarvinRabe\LaravelIntl\Concerns\WithLocales;
use MarvinRabe\LaravelIntl\Contracts\Intl;

class Number extends Intl
{
    use WithLocales;

    /**
     * Array of localized number formatters.
     *
     * @var array
     */
    protected $formatters;

    /**
     * Format a number.
     *
     * @param string|int|float $number
     * @param array $options
     * @return string
     */
    public function format($number, $options = [])
    {
        return $this->formatter()->format($number,
            $this->mergeOptions($options)
        );
    }

    /**
     * Format as percentage.
     *
     * @param string|int|float $number
     * @param array $options
     * @return string
     */
    public function percent($number, $options = [])
    {
        return $this->formatter()->format($number,
            $this->mergeOptions($options, ['style' => 'percent'])
        );
    }

    /**
     * Parse a localized number into native PHP format.
     *
     * @param string|int|float $number
     * @param array $options
     * @return string|false
     */
    public function parse($number, $options = [])
    {
        return $this->formatter()->parse($number,
            $this->mergeOptions($options)
        );
    }

    /**
     * Get the formatter's key.
     *
     * @param string $locale
     * @param string $fallbackLocale
     * @return string
     */
    protected function getLocalesKey($locale, $fallbackLocale)
    {
        return implode('|', [
            $locale,
            $fallbackLocale,
        ]);
    }

    /**
     * The current number formatter.
     *
     * @return \CommerceGuys\Intl\Formatter\NumberFormatter
     */
    protected function formatter()
    {
        $key = $this->getLocalesKey(
            $locale = $this->getLocale(),
            $fallbackLocale = $this->getFallbackLocale()
        );

        if (! isset($this->formatters[$key])) {
            $this->formatters[$key] = new NumberFormatter(new NumberFormatRepository($fallbackLocale), ['locale' => $locale]);
        }

        return $this->formatters[$key];
    }

    /**
     * Merges the options array.
     *
     * @param array $options
     * @param array $defaults
     * @return array
     */
    protected function mergeOptions(array $options, array $defaults = [])
    {
        Arr::forget($options, 'locale');

        return $defaults + $options;
    }
}
