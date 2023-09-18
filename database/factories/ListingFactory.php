<?php

namespace Database\Factories;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'tags' => 'laravel, api, backend',
            'company' => fake()->company(),
            'email' => fake()->email(),
            'website' => fake()->url(),
            'location' => fake()->city(),
            'description' => fake()->paragraph(5),
        ];
    }
}
