<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journey>
 */
class JourneyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // $apiKey = env("GOOGLE_API_KEY");
        // $response = Http::get("https://maps.googleapis.com/maps/api/js?key=" . $apiKey . "&callback=initMap&v=weekly&solution_channel=GMP_CCS_distancematrix_v1");

        // dd($response);


        // return [
        //     "start_lat" => 0,
        //     "start_lng" => 0,
        //     "end_lng" => 0,
        //     "end_lat" => 0,
        //     "date" => "2024-1-1",
        //     "distance" => 0,
        //     "co2_emissions" => 0,
        //     "cost" => 0,
        //     "user_id" => 1,
        // ];

        return [];
    }
}
