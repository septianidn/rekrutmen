<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Jobseeker;
use App\Models\Rekomendasi;

class RekomendasiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rekomendasi::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'jobseeker_id' => Jobseeker::factory(),
            'nama_perekomendasi' => $this->faker->regexify('[A-Za-z0-9]{30}'),
            'posisi' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'no_hp' => $this->faker->regexify('[A-Za-z0-9]{14}'),
            'alamat' => $this->faker->regexify('[A-Za-z0-9]{50}'),
        ];
    }
}
