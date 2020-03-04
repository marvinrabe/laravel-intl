<?php namespace MarvinRabe\LaravelIntl\Tests;

use Orchestra\Testbench\TestCase;
use MarvinRabe\LaravelIntl\Facades\Country;
use MarvinRabe\LaravelIntl\IntlServiceProvider;

class TestCountry extends TestCase
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

    protected function getEnvironmentSetUp($app)
    {
        $app->setBasePath(__DIR__ . '/..');
    }

    public function testHelper()
    {
        $this->assertEquals('Belgium', country('BE'));
        $this->assertEquals('MarvinRabe\LaravelIntl\Country', get_class(country()));
    }

    public function testHelperIsInSyncWithFacade()
    {
        Country::setLocale('foo');
        $this->assertEquals('foo', country()->getLocale());
    }

    public function testLocaleCanBeChanged()
    {
        $this->app->setLocale('nl');
        $this->assertEquals('België', Country::name('BE'));

        Country::setLocale('en');
        $this->assertEquals('Belgium', Country::name('BE'));
    }

    public function testFallbackLocaleIsUsed()
    {
        $country = Country::setLocale('foo');
        $country->setFallbackLocale('fr');
        $this->assertEquals('Belgique', $country->name('BE'));
    }

    public function testLocaleCanBeTemporarilyChanged()
    {
        $this->app->setLocale('nl');
        $name = Country::usingLocale('en', function($country) {
            return Country::name('BE');
        });

        $this->assertEquals('nl', Country::getLocale());
        $this->assertEquals('Belgium', $name);
    }

    public function testAll()
    {
        $countries = Country::all();
        $this->assertEquals('Belgium', $countries['BE']);
        $this->assertEquals('France', $countries['FR']);

        $countries = Country::setLocale('nl')->all();
        $this->assertEquals('België', $countries['BE']);
        $this->assertEquals('Frankrijk', $countries['FR']);
    }

    public function testName()
    {
        $country = Country::name('BE');
        $this->assertEquals('Belgium', $country);
    }
}
