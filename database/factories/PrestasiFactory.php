<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Jobseeker;
use App\Models\Prestasi;

class PrestasiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prestasi::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'jobseeker_id' => Jobseeker::factory(),
            'nama_penghargaan' => $this->faker->regexify('[A-Za-z0-9]{40}'),
            'tahun' => $this->faker->regexify('[A-Za-z0-9]{4}'),
            'dokumen' => $this->faker->regexify('[A-Za-z0-9]{250}'),
        ];
    }
}
