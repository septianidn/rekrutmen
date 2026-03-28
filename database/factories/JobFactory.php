<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employer;
use App\Models\Job;
use App\Models\Posisi;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'employer_id' => Employer::factory(),
            'nama_pekerjaan' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'kuota' => $this->faker->numberBetween(-10000, 10000),
            'posisi_id' => Posisi::factory(),
        ];
    }
}
