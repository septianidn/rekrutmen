<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employer;
use App\Models\IndustriType;
use App\Models\User;

class EmployerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nama_perusahaan' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'deskripsi_perusahaan' => $this->faker->text(),
            'industriType_id' => IndustriType::factory(),
            'alamat' => $this->faker->regexify('[A-Za-z0-9]{150}'),
        ];
    }
}
