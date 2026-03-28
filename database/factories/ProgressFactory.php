<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Progress;
use App\Models\Step;

class ProgressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Progress::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'application_id' => Progress::factory(),
            'step_id' => Step::factory(),
            'catatan' => $this->faker->text(),
            'lulus' => $this->faker->boolean(),
        ];
    }
}
