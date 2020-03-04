<?php

namespace MarvinRabe\LaravelIntl;

use CommerceGuys\Intl\Formatter\CurrencyFormatter;
use CommerceGuys\Intl\Currency\CurrencyRepository;
use CommerceGuys\Intl\NumberFormat\NumberFormatRepository;
use Illuminate\Support\Arr;
use MarvinRabe\LaravelIntl\Concerns\WithLocales;
use MarvinRabe\LaravelIntl\Contracts\Intl;

class Currency extends Intl
{
    use WithLocales;

    /**
     * Loaded localized currency data.
     *
     * @var array
     */
    protected $data;

    /**
     * Array of localized currency formatters.
     *
     * @var array
     */
    protected $formatters;

    /**
     * Get a localized record by key.
     *
     * @param string $currencyCode
     * @return string
     */
    public function get($currencyCode)
    {
        return $this->data()->get($currencyCode)->getName();
    }

    /**
     * Alias of get().
     *
     * @param string $currencyCode
     * @return string
     */
    public function name($currencyCode)
    {
        return $this->get($currencyCode);
    }

    /**
     * Get the symbol of the given currency.
     *
     * @param string $currencyCode
     * @return string
     */
    public function symbol($currencyCode)
    {
        return $this->data()->get($currencyCode)->getSymbol();
    }

    /**
     * Format a number.
     *
     * @param string|int|float $number
     * @param string $currencyCode
     * @param array $options
     * @return mixed|string
     */
    public function format($number, $currencyCode, $options = [])
    {
        return $this->formatter()->format($number, $currencyCode,
            $this->mergeOptions($options)
        );
    }

    /**
     * Format a number.
     *
     * @param string|int|float $number
     * @param string $currencyCode
     * @param array $options
     * @return mixed|string
     */
    public function formatAccounting($number, $currencyCode, $options = [])
    {
        return $this->formatter()->format($number, $currencyCode,
            $this->mergeOptions($options, ['style' => 'accounting'])
        );
    }

    /**
     * Parse a localized currency string into a number.
     *
     * @param string $number
     * @param string $currencyCode
     * @param array $options
     * @return mixed|string
     */
    public function parse($number, $currencyCode, $options = [])
    {
        return $this->formatter()->parse($number, $currencyCode,
            $this->mergeOptions($options)
        );
    }

    /**
     * Get all localized records.
     *
     * @return array
     */
    public function all()
    {
        return $this->data()->getList();
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
     * The currency repository.
     *
     * @return \CommerceGuys\Intl\Currency\CurrencyRepository
     */
    protected function data()
    {
        $key = $this->getLocalesKey(
            $locale = $this->getLocale(),
            $fallbackLocale = $this->getFallbackLocale()
        );

        if (! isset($this->data[$key])) {
            $this->data[$key] = new CurrencyRepository($locale, $fallbackLocale);
        }

        return $this->data[$key];
    }

    /**
     * The current number formatter.
     *
     * @return \CommerceGuys\Intl\Formatter\CurrencyFormatter
     */
    protected function formatter()
    {
        $key = $this->getLocalesKey(
            $locale = $this->getLocale(),
            $fallbackLocale = $this->getFallbackLocale()
        );

        if (! isset($this->formatters[$key])) {
            $this->formatters[$key] = new CurrencyFormatter(
                new NumberFormatRepository($fallbackLocale),
                $this->data(),
                ['locale' => $locale]
            );
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
