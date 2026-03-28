<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Jobseeker;
use App\Models\Pelatihan;

class PelatihanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pelatihan::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'jobseeker_id' => Jobseeker::factory(),
            'nama_pelatihan' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'tahun' => $this->faker->regexify('[A-Za-z0-9]{4}'),
            'sertifikat' => $this->faker->regexify('[A-Za-z0-9]{250}'),
        ];
    }
}
