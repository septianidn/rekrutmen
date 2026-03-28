<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Jobseeker;
use App\Models\Organisasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrganisasiController
 */
final class OrganisasiControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $organisasis = Organisasi::factory()->count(3)->create();

        $response = $this->get(route('organisasi.index'));

        $response->assertOk();
        $response->assertViewIs('organisasi.index');
        $response->assertViewHas('organisasis');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('organisasi.create'));

        $response->assertOk();
        $response->assertViewIs('organisasi.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrganisasiController::class,
            'store',
            \App\Http\Requests\OrganisasiStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $jobseeker = Jobseeker::factory()->create();
        $nama_organisasi = $this->faker->word();
        $jabatan = $this->faker->word();
        $keterangan = $this->faker->text();

        $response = $this->post(route('organisasi.store'), [
            'jobseeker_id' => $jobseeker->id,
            'nama_organisasi' => $nama_organisasi,
            'jabatan' => $jabatan,
            'keterangan' => $keterangan,
        ]);

        $organisasis = Organisasi::query()
            ->where('jobseeker_id', $jobseeker->id)
            ->where('nama_organisasi', $nama_organisasi)
            ->where('jabatan', $jabatan)
            ->where('keterangan', $keterangan)
            ->get();
        $this->assertCount(1, $organisasis);
        $organisasi = $organisasis->first();

        $response->assertRedirect(route('organisasi.index'));
        $response->assertSessionHas('organisasi.id', $organisasi->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $organisasi = Organisasi::factory()->create();

        $response = $this->get(route('organisasi.show', $organisasi));

        $response->assertOk();
        $response->assertViewIs('organisasi.show');
        $response->assertViewHas('organisasi');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $organisasi = Organisasi::factory()->create();

        $response = $this->get(route('organisasi.edit', $organisasi));

        $response->assertOk();
        $response->assertViewIs('organisasi.edit');
        $response->assertViewHas('organisasi');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrganisasiController::class,
            'update',
            \App\Http\Requests\OrganisasiUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $organisasi = Organisasi::factory()->create();
        $jobseeker = Jobseeker::factory()->create();
        $nama_organisasi = $this->faker->word();
        $jabatan = $this->faker->word();
        $keterangan = $this->faker->text();

        $response = $this->put(route('organisasi.update', $organisasi), [
            'jobseeker_id' => $jobseeker->id,
            'nama_organisasi' => $nama_organisasi,
            'jabatan' => $jabatan,
            'keterangan' => $keterangan,
        ]);

        $organisasi->refresh();

        $response->assertRedirect(route('organisasi.index'));
        $response->assertSessionHas('organisasi.id', $organisasi->id);

        $this->assertEquals($jobseeker->id, $organisasi->jobseeker_id);
        $this->assertEquals($nama_organisasi, $organisasi->nama_organisasi);
        $this->assertEquals($jabatan, $organisasi->jabatan);
        $this->assertEquals($keterangan, $organisasi->keterangan);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $organisasi = Organisasi::factory()->create();

        $response = $this->delete(route('organisasi.destroy', $organisasi));

        $response->assertRedirect(route('organisasi.index'));

        $this->assertModelMissing($organisasi);
    }
}
