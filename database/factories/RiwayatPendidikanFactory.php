<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Jobseeker;
use App\Models\RiwayatPendidikan;

class RiwayatPendidikanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RiwayatPendidikan::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'jobseeker_id' => Jobseeker::factory(),
            'jenjang' => $this->faker->regexify('[A-Za-z0-9]{5}'),
            'instansi' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'indeks_nilai' => $this->faker->regexify('[A-Za-z0-9]{4}'),
            'keterangan' => $this->faker->text(),
        ];
    }
}
