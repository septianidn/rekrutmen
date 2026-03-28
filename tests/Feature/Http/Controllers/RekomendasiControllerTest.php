<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Jobseeker;
use App\Models\Rekomendasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RekomendasiController
 */
final class RekomendasiControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $rekomendasis = Rekomendasi::factory()->count(3)->create();

        $response = $this->get(route('rekomendasi.index'));

        $response->assertOk();
        $response->assertViewIs('rekomendasi.index');
        $response->assertViewHas('rekomendasis');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('rekomendasi.create'));

        $response->assertOk();
        $response->assertViewIs('rekomendasi.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RekomendasiController::class,
            'store',
            \App\Http\Requests\RekomendasiStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $jobseeker = Jobseeker::factory()->create();
        $nama_perekomendasi = $this->faker->word();
        $posisi = $this->faker->word();
        $no_hp = $this->faker->word();
        $alamat = $this->faker->word();

        $response = $this->post(route('rekomendasi.store'), [
            'jobseeker_id' => $jobseeker->id,
            'nama_perekomendasi' => $nama_perekomendasi,
            'posisi' => $posisi,
            'no_hp' => $no_hp,
            'alamat' => $alamat,
        ]);

        $rekomendasis = Rekomendasi::query()
            ->where('jobseeker_id', $jobseeker->id)
            ->where('nama_perekomendasi', $nama_perekomendasi)
            ->where('posisi', $posisi)
            ->where('no_hp', $no_hp)
            ->where('alamat', $alamat)
            ->get();
        $this->assertCount(1, $rekomendasis);
        $rekomendasi = $rekomendasis->first();

        $response->assertRedirect(route('rekomendasi.index'));
        $response->assertSessionHas('rekomendasi.id', $rekomendasi->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $rekomendasi = Rekomendasi::factory()->create();

        $response = $this->get(route('rekomendasi.show', $rekomendasi));

        $response->assertOk();
        $response->assertViewIs('rekomendasi.show');
        $response->assertViewHas('rekomendasi');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $rekomendasi = Rekomendasi::factory()->create();

        $response = $this->get(route('rekomendasi.edit', $rekomendasi));

        $response->assertOk();
        $response->assertViewIs('rekomendasi.edit');
        $response->assertViewHas('rekomendasi');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RekomendasiController::class,
            'update',
            \App\Http\Requests\RekomendasiUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $rekomendasi = Rekomendasi::factory()->create();
        $jobseeker = Jobseeker::factory()->create();
        $nama_perekomendasi = $this->faker->word();
        $posisi = $this->faker->word();
        $no_hp = $this->faker->word();
        $alamat = $this->faker->word();

        $response = $this->put(route('rekomendasi.update', $rekomendasi), [
            'jobseeker_id' => $jobseeker->id,
            'nama_perekomendasi' => $nama_perekomendasi,
            'posisi' => $posisi,
            'no_hp' => $no_hp,
            'alamat' => $alamat,
        ]);

        $rekomendasi->refresh();

        $response->assertRedirect(route('rekomendasi.index'));
        $response->assertSessionHas('rekomendasi.id', $rekomendasi->id);

        $this->assertEquals($jobseeker->id, $rekomendasi->jobseeker_id);
        $this->assertEquals($nama_perekomendasi, $rekomendasi->nama_perekomendasi);
        $this->assertEquals($posisi, $rekomendasi->posisi);
        $this->assertEquals($no_hp, $rekomendasi->no_hp);
        $this->assertEquals($alamat, $rekomendasi->alamat);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $rekomendasi = Rekomendasi::factory()->create();

        $response = $this->delete(route('rekomendasi.destroy', $rekomendasi));

        $response->assertRedirect(route('rekomendasi.index'));

        $this->assertModelMissing($rekomendasi);
    }
}
