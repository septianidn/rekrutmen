<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Jobseeker;
use App\Models\Prestasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PrestasiController
 */
final class PrestasiControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $prestasis = Prestasi::factory()->count(3)->create();

        $response = $this->get(route('prestasi.index'));

        $response->assertOk();
        $response->assertViewIs('prestasi.index');
        $response->assertViewHas('prestasis');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('prestasi.create'));

        $response->assertOk();
        $response->assertViewIs('prestasi.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PrestasiController::class,
            'store',
            \App\Http\Requests\PrestasiStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $jobseeker = Jobseeker::factory()->create();
        $nama_penghargaan = $this->faker->word();
        $tahun = $this->faker->word();
        $dokumen = $this->faker->word();

        $response = $this->post(route('prestasi.store'), [
            'jobseeker_id' => $jobseeker->id,
            'nama_penghargaan' => $nama_penghargaan,
            'tahun' => $tahun,
            'dokumen' => $dokumen,
        ]);

        $prestasis = Prestasi::query()
            ->where('jobseeker_id', $jobseeker->id)
            ->where('nama_penghargaan', $nama_penghargaan)
            ->where('tahun', $tahun)
            ->where('dokumen', $dokumen)
            ->get();
        $this->assertCount(1, $prestasis);
        $prestasi = $prestasis->first();

        $response->assertRedirect(route('prestasi.index'));
        $response->assertSessionHas('prestasi.id', $prestasi->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $prestasi = Prestasi::factory()->create();

        $response = $this->get(route('prestasi.show', $prestasi));

        $response->assertOk();
        $response->assertViewIs('prestasi.show');
        $response->assertViewHas('prestasi');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $prestasi = Prestasi::factory()->create();

        $response = $this->get(route('prestasi.edit', $prestasi));

        $response->assertOk();
        $response->assertViewIs('prestasi.edit');
        $response->assertViewHas('prestasi');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PrestasiController::class,
            'update',
            \App\Http\Requests\PrestasiUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $prestasi = Prestasi::factory()->create();
        $jobseeker = Jobseeker::factory()->create();
        $nama_penghargaan = $this->faker->word();
        $tahun = $this->faker->word();
        $dokumen = $this->faker->word();

        $response = $this->put(route('prestasi.update', $prestasi), [
            'jobseeker_id' => $jobseeker->id,
            'nama_penghargaan' => $nama_penghargaan,
            'tahun' => $tahun,
            'dokumen' => $dokumen,
        ]);

        $prestasi->refresh();

        $response->assertRedirect(route('prestasi.index'));
        $response->assertSessionHas('prestasi.id', $prestasi->id);

        $this->assertEquals($jobseeker->id, $prestasi->jobseeker_id);
        $this->assertEquals($nama_penghargaan, $prestasi->nama_penghargaan);
        $this->assertEquals($tahun, $prestasi->tahun);
        $this->assertEquals($dokumen, $prestasi->dokumen);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $prestasi = Prestasi::factory()->create();

        $response = $this->delete(route('prestasi.destroy', $prestasi));

        $response->assertRedirect(route('prestasi.index'));

        $this->assertModelMissing($prestasi);
    }
}
