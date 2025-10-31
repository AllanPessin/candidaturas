<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Modalities;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'position' => $this->faker->jobTitle(),
            'link' => $this->faker->url(),
            'contact' => $this->faker->email(),
            'applied_date' => $this->faker->date(),
            'interview_date' => $this->faker->date(),
            'salary' => $this->faker->randomNumber(5, true),
            'feedback' => $this->faker->paragraph(),
            'status_id' => Status::factory(),
            'company_id' => Company::factory(),
            'city_id' => City::factory(),
            'modality_id' => Modalities::factory(),
            'contract_id' => Contract::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
