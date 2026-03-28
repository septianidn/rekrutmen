<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Posisi;

class PosisiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Posisi::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama_posisi' => $this->faker->regexify('[A-Za-z0-9]{25}'),
        ];
    }
}
