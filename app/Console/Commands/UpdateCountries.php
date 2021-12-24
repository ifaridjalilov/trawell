<?php

namespace App\Console\Commands;

use App\Services\ExternalCountryInterface;
use Illuminate\Console\Command;

class UpdateCountries extends Command
{
    protected $signature = 'command:update_countries';

    protected $description = 'Update all countries from external API';

    public function handle(ExternalCountryInterface $countryService): int
    {
        $countryService->updateCountries();
        return 0;
    }
}
