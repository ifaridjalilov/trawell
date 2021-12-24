<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Services\ExternalCountryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ExternalCountryServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var ExternalCountryInterface */
    private $countryService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->countryService = $this->app->make(ExternalCountryInterface::class);
    }

    public function test_update_countries()
    {
        $this->assertCount(0, Country::all());
        $this->countryService->updateCountries();
        $this->assertNotEmpty(Country::all());
    }

    public function test_diplomatic_missions_cache()
    {
        $slug = 'azerbaijan';
        $key = "country_diplomatic_missions_$slug";
        Cache::shouldReceive('remember')
            ->once()
            ->with($key, 86400, \Closure::class)
        ;
        $this->countryService->getDiplomaticMissions($slug);
    }
}
