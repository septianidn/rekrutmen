<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Account;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama_bank' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'atas_nama' => $this->faker->regexify('[A-Za-z0-9]{35}'),
        ];
    }
}
