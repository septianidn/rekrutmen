<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Jobseeker;
use App\Models\Pelatihan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PelatihanController
 */
final class PelatihanControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $pelatihans = Pelatihan::factory()->count(3)->create();

        $response = $this->get(route('pelatihan.index'));

        $response->assertOk();
        $response->assertViewIs('pelatihan.index');
        $response->assertViewHas('pelatihans');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('pelatihan.create'));

        $response->assertOk();
        $response->assertViewIs('pelatihan.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PelatihanController::class,
            'store',
            \App\Http\Requests\PelatihanStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $jobseeker = Jobseeker::factory()->create();
        $nama_pelatihan = $this->faker->word();
        $tahun = $this->faker->word();
        $sertifikat = $this->faker->word();

        $response = $this->post(route('pelatihan.store'), [
            'jobseeker_id' => $jobseeker->id,
            'nama_pelatihan' => $nama_pelatihan,
            'tahun' => $tahun,
            'sertifikat' => $sertifikat,
        ]);

        $pelatihans = Pelatihan::query()
            ->where('jobseeker_id', $jobseeker->id)
            ->where('nama_pelatihan', $nama_pelatihan)
            ->where('tahun', $tahun)
            ->where('sertifikat', $sertifikat)
            ->get();
        $this->assertCount(1, $pelatihans);
        $pelatihan = $pelatihans->first();

        $response->assertRedirect(route('pelatihan.index'));
        $response->assertSessionHas('pelatihan.id', $pelatihan->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $pelatihan = Pelatihan::factory()->create();

        $response = $this->get(route('pelatihan.show', $pelatihan));

        $response->assertOk();
        $response->assertViewIs('pelatihan.show');
        $response->assertViewHas('pelatihan');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $pelatihan = Pelatihan::factory()->create();

        $response = $this->get(route('pelatihan.edit', $pelatihan));

        $response->assertOk();
        $response->assertViewIs('pelatihan.edit');
        $response->assertViewHas('pelatihan');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PelatihanController::class,
            'update',
            \App\Http\Requests\PelatihanUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $pelatihan = Pelatihan::factory()->create();
        $jobseeker = Jobseeker::factory()->create();
        $nama_pelatihan = $this->faker->word();
        $tahun = $this->faker->word();
        $sertifikat = $this->faker->word();

        $response = $this->put(route('pelatihan.update', $pelatihan), [
            'jobseeker_id' => $jobseeker->id,
            'nama_pelatihan' => $nama_pelatihan,
            'tahun' => $tahun,
            'sertifikat' => $sertifikat,
        ]);

        $pelatihan->refresh();

        $response->assertRedirect(route('pelatihan.index'));
        $response->assertSessionHas('pelatihan.id', $pelatihan->id);

        $this->assertEquals($jobseeker->id, $pelatihan->jobseeker_id);
        $this->assertEquals($nama_pelatihan, $pelatihan->nama_pelatihan);
        $this->assertEquals($tahun, $pelatihan->tahun);
        $this->assertEquals($sertifikat, $pelatihan->sertifikat);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $pelatihan = Pelatihan::factory()->create();

        $response = $this->delete(route('pelatihan.destroy', $pelatihan));

        $response->assertRedirect(route('pelatihan.index'));

        $this->assertModelMissing($pelatihan);
    }
}
