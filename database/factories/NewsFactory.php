<?php

namespace Database\Factories;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => fake()->title(),
            'contenu' => fake()->text(),
            'categorie' => Category::inRandomOrder()->first()->id,
            'date_debut' => Carbon::now(),
            'date_expiration' => $this->futureDate()
        ];
    }

    public function futureDate()
    {
        // Get the current date
        $currentDate = Carbon::now();

        // Generate a random number of days (between 1 and 30 for example)
        $randomDays = rand(1, 30);

        // Add the random number of days to the current date
        $futureDate = $currentDate->addDays($randomDays);

        // Output the future date
        return $futureDate;
    }
}
