<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Users;

class UsersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Users::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'password' => $this->faker->password(),
            'email' => $this->faker->safeEmail(),
            'email_verified_at' => $this->faker->dateTime(),
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->regexify('[A-Za-z0-9]{150}'),
            'user_type' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'status' => $this->faker->randomElement(["pending","active","blocked","inactive"]),
            'profile_image' => $this->faker->regexify('[A-Za-z0-9]{250}'),
        ];
    }
}
