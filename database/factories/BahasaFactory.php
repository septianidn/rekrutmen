<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Bahasa;
use App\Models\Jobseeker;

class BahasaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bahasa::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'jobseeker_id' => Jobseeker::factory(),
            'bahasa' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'keterangan' => $this->faker->text(),
        ];
    }
}
