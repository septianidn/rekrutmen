<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Proses;

class ProsesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proses::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama_proses' => $this->faker->regexify('[A-Za-z0-9]{50}'),
        ];
    }
}
