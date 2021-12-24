<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CountryService implements ExternalCountryInterface
{
    private $token = '8844ac20-006c-4237-a32d-a85e35e60c4f';
    private $url = 'https://diplomatic-missions.pickvisa.com/api/v1';

    private function get(string $endpoint)
    {
        $response = Http::withHeaders(['Authorization' => $this->token])
            ->get("$this->url/$endpoint")
        ;

        if ($response->status() !== Response::HTTP_OK) {
            // Logging
        }

        return $response->json();
    }

    public function updateCountries(): void
    {
        $data = $this->get("countries/all");

        DB::beginTransaction();
        try {
            Country::query()->truncate();
            $this->insertCountries($data);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    private function insertCountries(array $data): void
    {
        foreach ($data as $country) {
            Country::query()->create([
                'slug' => $country['slug'],
                'display_name' => $country['display_name'],
            ]);
        }
    }

    public function getDiplomaticMissions(string $slug): array
    {
        $result = Cache::remember("country_diplomatic_missions_$slug", 86400, function () use ($slug) {
            $data = $this->get("diplomatic-missions/host-country/$slug");
            return $this->getDiplomaticMissionsFromResponse($data['diplomatic_missions']);
        });

        return $result ?? [];
    }

    private function getDiplomaticMissionsFromResponse(array $diplomaticMissionsResponse): array
    {
        $diplomaticMissions = [];
        foreach ($diplomaticMissionsResponse as $diplomaticMission) {
            $diplomaticMissions[] = [
                'website' => $diplomaticMission['website'],
                'city' => $diplomaticMission['city'],
                'address' => $diplomaticMission['address'],
                'office_hours' => $diplomaticMission['office_hours'],
                'note' => $diplomaticMission['note'],
                'type' => $diplomaticMission['type'] ? $diplomaticMission['type']['name'] : '',
                'emails' => array_column($diplomaticMission['emails'], 'address'),
                'phones' => array_column($diplomaticMission['phones'], 'number'),
            ];
        }
        return $diplomaticMissions;
    }
}
