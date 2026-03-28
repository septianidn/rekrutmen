<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Prose;
use App\Models\Proses;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProsesController
 */
final class ProsesControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $proses = Proses::factory()->count(3)->create();

        $response = $this->get(route('prose.index'));

        $response->assertOk();
        $response->assertViewIs('prose.index');
        $response->assertViewHas('proses');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('prose.create'));

        $response->assertOk();
        $response->assertViewIs('prose.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProsesController::class,
            'store',
            \App\Http\Requests\ProsesStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nama_proses = $this->faker->word();

        $response = $this->post(route('prose.store'), [
            'nama_proses' => $nama_proses,
        ]);

        $proses = Prose::query()
            ->where('nama_proses', $nama_proses)
            ->get();
        $this->assertCount(1, $proses);
        $prose = $proses->first();

        $response->assertRedirect(route('prose.index'));
        $response->assertSessionHas('prose.id', $prose->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $prose = Proses::factory()->create();

        $response = $this->get(route('prose.show', $prose));

        $response->assertOk();
        $response->assertViewIs('prose.show');
        $response->assertViewHas('prose');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $prose = Proses::factory()->create();

        $response = $this->get(route('prose.edit', $prose));

        $response->assertOk();
        $response->assertViewIs('prose.edit');
        $response->assertViewHas('prose');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProsesController::class,
            'update',
            \App\Http\Requests\ProsesUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $prose = Proses::factory()->create();
        $nama_proses = $this->faker->word();

        $response = $this->put(route('prose.update', $prose), [
            'nama_proses' => $nama_proses,
        ]);

        $prose->refresh();

        $response->assertRedirect(route('prose.index'));
        $response->assertSessionHas('prose.id', $prose->id);

        $this->assertEquals($nama_proses, $prose->nama_proses);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $prose = Proses::factory()->create();
        $prose = Prose::factory()->create();

        $response = $this->delete(route('prose.destroy', $prose));

        $response->assertRedirect(route('prose.index'));

        $this->assertModelMissing($prose);
    }
}
