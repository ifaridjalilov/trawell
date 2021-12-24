<?php

namespace App\Services;

interface ExternalCountryInterface
{
    public function updateCountries(): void;

    public function getDiplomaticMissions(string $slug): array;
}
