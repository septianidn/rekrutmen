<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Jobseeker;
use App\Models\JobseekerType;
use App\Models\User;

class JobseekerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Jobseeker::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'jenis_kelamin' => $this->faker->regexify('[A-Za-z0-9]{15}'),
            'ttl' => $this->faker->date(),
            'jobseeker_id_type' => JobseekerType::factory(),
            'jobseeker_type_id' => JobseekerType::factory(),
        ];
    }
}
