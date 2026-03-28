<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Jobseeker;
use App\Models\RiwayatKerja;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RiwayatKerjaController
 */
final class RiwayatKerjaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $riwayatKerjas = RiwayatKerja::factory()->count(3)->create();

        $response = $this->get(route('riwayat-kerja.index'));

        $response->assertOk();
        $response->assertViewIs('riwayatKerja.index');
        $response->assertViewHas('riwayatKerjas');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('riwayat-kerja.create'));

        $response->assertOk();
        $response->assertViewIs('riwayatKerja.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RiwayatKerjaController::class,
            'store',
            \App\Http\Requests\RiwayatKerjaStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $jobseeker = Jobseeker::factory()->create();
        $keterangan = $this->faker->text();

        $response = $this->post(route('riwayat-kerja.store'), [
            'jobseeker_id' => $jobseeker->id,
            'keterangan' => $keterangan,
        ]);

        $riwayatKerjas = RiwayatKerja::query()
            ->where('jobseeker_id', $jobseeker->id)
            ->where('keterangan', $keterangan)
            ->get();
        $this->assertCount(1, $riwayatKerjas);
        $riwayatKerja = $riwayatKerjas->first();

        $response->assertRedirect(route('riwayat-kerja.index'));
        $response->assertSessionHas('riwayatKerja.id', $riwayatKerja->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $riwayatKerja = RiwayatKerja::factory()->create();

        $response = $this->get(route('riwayat-kerja.show', $riwayatKerja));

        $response->assertOk();
        $response->assertViewIs('riwayatKerja.show');
        $response->assertViewHas('riwayatKerja');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $riwayatKerja = RiwayatKerja::factory()->create();

        $response = $this->get(route('riwayat-kerja.edit', $riwayatKerja));

        $response->assertOk();
        $response->assertViewIs('riwayatKerja.edit');
        $response->assertViewHas('riwayatKerja');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RiwayatKerjaController::class,
            'update',
            \App\Http\Requests\RiwayatKerjaUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $riwayatKerja = RiwayatKerja::factory()->create();
        $jobseeker = Jobseeker::factory()->create();
        $keterangan = $this->faker->text();

        $response = $this->put(route('riwayat-kerja.update', $riwayatKerja), [
            'jobseeker_id' => $jobseeker->id,
            'keterangan' => $keterangan,
        ]);

        $riwayatKerja->refresh();

        $response->assertRedirect(route('riwayat-kerja.index'));
        $response->assertSessionHas('riwayatKerja.id', $riwayatKerja->id);

        $this->assertEquals($jobseeker->id, $riwayatKerja->jobseeker_id);
        $this->assertEquals($keterangan, $riwayatKerja->keterangan);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $riwayatKerja = RiwayatKerja::factory()->create();

        $response = $this->delete(route('riwayat-kerja.destroy', $riwayatKerja));

        $response->assertRedirect(route('riwayat-kerja.index'));

        $this->assertModelMissing($riwayatKerja);
    }
}
