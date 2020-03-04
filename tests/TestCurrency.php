<?php namespace MarvinRabe\LaravelIntl\Tests;

use Orchestra\Testbench\TestCase;
use MarvinRabe\LaravelIntl\Facades\Currency;
use MarvinRabe\LaravelIntl\IntlServiceProvider;

class TestCurrency extends TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $application
     * @return array
     */
    protected function getPackageProviders($application)
    {
        return [IntlServiceProvider::class];
    }

    public function setUp(): void
    {
        require_once __DIR__.'/../src/Helpers.php';

        parent::setUp();
    }

    public function testHelper()
    {
        $this->assertEquals('US Dollar', currency('USD'));
        $this->assertEquals('MarvinRabe\LaravelIntl\Currency', get_class(currency()));
        $this->assertEquals('€1,234.00', currency(1234, 'EUR'));
    }

    public function testHelperIsInSyncWithFacade()
    {
        Currency::setLocale('foo');
        $this->assertEquals('foo', currency()->getLocale());
    }

    public function testLocaleCanBeChanged()
    {
        $this->app->setLocale('nl');
        $this->assertEquals('Amerikaanse dollar', Currency::name('USD'));
        $this->assertEquals('€ 1.234,00', Currency::format(1234, 'EUR'));

        Currency::setLocale('en');
        $this->assertEquals('US Dollar', Currency::name('USD'));
    }

    public function testFallbackLocaleIsUsed()
    {
        Currency::setLocale('foo');
        Currency::setFallbackLocale('fr');

        $currency = Currency::format(1234, 'EUR');

        $this->assertEquals('1 234,00 €', $currency);
    }

    public function testLocaleCanBeTemporarilyChanged()
    {
        $this->app->setLocale('nl');
        $name = Currency::usingLocale('en', function($currency) {
            return Currency::name('USD');
        });

        $this->assertEquals('nl', Currency::getLocale());
        $this->assertEquals('US Dollar', $name);
    }

    public function testGet()
    {
        $currency = Currency::get('USD');
        $this->assertEquals('US Dollar', $currency);
    }

    public function testAll()
    {
        $currencies = Currency::all();
        $this->assertEquals('Euro', $currencies['EUR']);
        $this->assertEquals('US Dollar', $currencies['USD']);

        $currencies = Currency::setLocale('nl')->all();
        $this->assertEquals('Euro', $currencies['EUR']);
        $this->assertEquals('Amerikaanse dollar', $currencies['USD']);
    }

    public function testName()
    {
        $currency = Currency::name('USD');
        $this->assertEquals('US Dollar', $currency);
    }

    public function testSymbol()
    {
        $currency = Currency::symbol('USD');
        $this->assertEquals('$', $currency);
    }

    public function testFormat()
    {
        $currency = Currency::format(1234, 'EUR');
        $this->assertEquals('€1,234.00', $currency);
    }

    public function testFormatAccounting()
    {
        $currency = Currency::formatAccounting(-1234, 'EUR');
        $this->assertEquals('(€1,234.00)', $currency);
    }

    public function testParse()
    {
        $this->app->setLocale('nl');
        $currency = Currency::parse('€ 1.234,50', 'EUR');
        $this->assertEquals(1234.5, $currency);
    }
}
