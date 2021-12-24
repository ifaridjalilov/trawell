<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Services\ExternalCountryInterface;

class HomeController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return view('countries', compact('countries'));
    }

    public function show(Country $country, ExternalCountryInterface $countryService)
    {
        $diplomaticMissions = $countryService->getDiplomaticMissions($country->slug);
        return view('country_detail', compact('country', 'diplomaticMissions'));
    }
}
