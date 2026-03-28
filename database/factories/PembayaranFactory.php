<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\Pembayaran;
use App\Models\User;

class PembayaranFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pembayaran::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'membership_id' => Pembayaran::factory(),
            'tgl_mulai' => $this->faker->date(),
            'tgl_berakhir' => $this->faker->date(),
            'nomor_rekening' => Account::factory(),
            'account_id' => Account::factory(),
        ];
    }
}
