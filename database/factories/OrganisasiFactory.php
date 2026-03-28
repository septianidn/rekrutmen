<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Jobseeker;
use App\Models\Organisasi;

class OrganisasiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organisasi::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'jobseeker_id' => Jobseeker::factory(),
            'nama_organisasi' => $this->faker->regexify('[A-Za-z0-9]{30}'),
            'jabatan' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'keterangan' => $this->faker->text(),
        ];
    }
}
