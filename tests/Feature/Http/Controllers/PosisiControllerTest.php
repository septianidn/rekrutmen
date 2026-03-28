<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Posisi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PosisiController
 */
final class PosisiControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $posisis = Posisi::factory()->count(3)->create();

        $response = $this->get(route('posisi.index'));

        $response->assertOk();
        $response->assertViewIs('posisi.index');
        $response->assertViewHas('posisis');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('posisi.create'));

        $response->assertOk();
        $response->assertViewIs('posisi.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PosisiController::class,
            'store',
            \App\Http\Requests\PosisiStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nama_posisi = $this->faker->word();

        $response = $this->post(route('posisi.store'), [
            'nama_posisi' => $nama_posisi,
        ]);

        $posisis = Posisi::query()
            ->where('nama_posisi', $nama_posisi)
            ->get();
        $this->assertCount(1, $posisis);
        $posisi = $posisis->first();

        $response->assertRedirect(route('posisi.index'));
        $response->assertSessionHas('posisi.id', $posisi->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $posisi = Posisi::factory()->create();

        $response = $this->get(route('posisi.show', $posisi));

        $response->assertOk();
        $response->assertViewIs('posisi.show');
        $response->assertViewHas('posisi');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $posisi = Posisi::factory()->create();

        $response = $this->get(route('posisi.edit', $posisi));

        $response->assertOk();
        $response->assertViewIs('posisi.edit');
        $response->assertViewHas('posisi');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PosisiController::class,
            'update',
            \App\Http\Requests\PosisiUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $posisi = Posisi::factory()->create();
        $nama_posisi = $this->faker->word();

        $response = $this->put(route('posisi.update', $posisi), [
            'nama_posisi' => $nama_posisi,
        ]);

        $posisi->refresh();

        $response->assertRedirect(route('posisi.index'));
        $response->assertSessionHas('posisi.id', $posisi->id);

        $this->assertEquals($nama_posisi, $posisi->nama_posisi);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $posisi = Posisi::factory()->create();

        $response = $this->delete(route('posisi.destroy', $posisi));

        $response->assertRedirect(route('posisi.index'));

        $this->assertModelMissing($posisi);
    }
}
