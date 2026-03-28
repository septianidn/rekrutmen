<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Membership;

class MembershipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Membership::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama_membership' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'durasi' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'harga' => $this->faker->regexify('[A-Za-z0-9]{50}'),
        ];
    }
}
