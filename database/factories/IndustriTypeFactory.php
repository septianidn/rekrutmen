<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employer;
use App\Models\IndustriType;

class IndustriTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = IndustriType::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama_industri' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'employer_id' => Employer::factory(),
        ];
    }
}
