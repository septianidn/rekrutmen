<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Jobseeker;
use App\Models\RiwayatPendidikan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RiwayatPendidikanController
 */
final class RiwayatPendidikanControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $riwayatPendidikans = RiwayatPendidikan::factory()->count(3)->create();

        $response = $this->get(route('riwayat-pendidikan.index'));

        $response->assertOk();
        $response->assertViewIs('riwayatPendidikan.index');
        $response->assertViewHas('riwayatPendidikans');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('riwayat-pendidikan.create'));

        $response->assertOk();
        $response->assertViewIs('riwayatPendidikan.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RiwayatPendidikanController::class,
            'store',
            \App\Http\Requests\RiwayatPendidikanStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $jobseeker = Jobseeker::factory()->create();
        $jenjang = $this->faker->word();
        $instansi = $this->faker->word();
        $keterangan = $this->faker->text();

        $response = $this->post(route('riwayat-pendidikan.store'), [
            'jobseeker_id' => $jobseeker->id,
            'jenjang' => $jenjang,
            'instansi' => $instansi,
            'keterangan' => $keterangan,
        ]);

        $riwayatPendidikans = RiwayatPendidikan::query()
            ->where('jobseeker_id', $jobseeker->id)
            ->where('jenjang', $jenjang)
            ->where('instansi', $instansi)
            ->where('keterangan', $keterangan)
            ->get();
        $this->assertCount(1, $riwayatPendidikans);
        $riwayatPendidikan = $riwayatPendidikans->first();

        $response->assertRedirect(route('riwayat-pendidikan.index'));
        $response->assertSessionHas('riwayatPendidikan.id', $riwayatPendidikan->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $riwayatPendidikan = RiwayatPendidikan::factory()->create();

        $response = $this->get(route('riwayat-pendidikan.show', $riwayatPendidikan));

        $response->assertOk();
        $response->assertViewIs('riwayatPendidikan.show');
        $response->assertViewHas('riwayatPendidikan');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $riwayatPendidikan = RiwayatPendidikan::factory()->create();

        $response = $this->get(route('riwayat-pendidikan.edit', $riwayatPendidikan));

        $response->assertOk();
        $response->assertViewIs('riwayatPendidikan.edit');
        $response->assertViewHas('riwayatPendidikan');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RiwayatPendidikanController::class,
            'update',
            \App\Http\Requests\RiwayatPendidikanUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $riwayatPendidikan = RiwayatPendidikan::factory()->create();
        $jobseeker = Jobseeker::factory()->create();
        $jenjang = $this->faker->word();
        $instansi = $this->faker->word();
        $keterangan = $this->faker->text();

        $response = $this->put(route('riwayat-pendidikan.update', $riwayatPendidikan), [
            'jobseeker_id' => $jobseeker->id,
            'jenjang' => $jenjang,
            'instansi' => $instansi,
            'keterangan' => $keterangan,
        ]);

        $riwayatPendidikan->refresh();

        $response->assertRedirect(route('riwayat-pendidikan.index'));
        $response->assertSessionHas('riwayatPendidikan.id', $riwayatPendidikan->id);

        $this->assertEquals($jobseeker->id, $riwayatPendidikan->jobseeker_id);
        $this->assertEquals($jenjang, $riwayatPendidikan->jenjang);
        $this->assertEquals($instansi, $riwayatPendidikan->instansi);
        $this->assertEquals($keterangan, $riwayatPendidikan->keterangan);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $riwayatPendidikan = RiwayatPendidikan::factory()->create();

        $response = $this->delete(route('riwayat-pendidikan.destroy', $riwayatPendidikan));

        $response->assertRedirect(route('riwayat-pendidikan.index'));

        $this->assertModelMissing($riwayatPendidikan);
    }
}
