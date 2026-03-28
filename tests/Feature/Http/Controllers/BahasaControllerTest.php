<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Bahasa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BahasaController
 */
final class BahasaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $bahasas = Bahasa::factory()->count(3)->create();

        $response = $this->get(route('bahasa.index'));

        $response->assertOk();
        $response->assertViewIs('bahasa.index');
        $response->assertViewHas('bahasas');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('bahasa.create'));

        $response->assertOk();
        $response->assertViewIs('bahasa.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BahasaController::class,
            'store',
            \App\Http\Requests\BahasaStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $bahasa = $this->faker->word();

        $response = $this->post(route('bahasa.store'), [
            'bahasa' => $bahasa,
        ]);

        $bahasas = Bahasa::query()
            ->where('bahasa', $bahasa)
            ->get();
        $this->assertCount(1, $bahasas);
        $bahasa = $bahasas->first();

        $response->assertRedirect(route('bahasa.index'));
        $response->assertSessionHas('bahasa.id', $bahasa->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $bahasa = Bahasa::factory()->create();

        $response = $this->get(route('bahasa.show', $bahasa));

        $response->assertOk();
        $response->assertViewIs('bahasa.show');
        $response->assertViewHas('bahasa');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $bahasa = Bahasa::factory()->create();

        $response = $this->get(route('bahasa.edit', $bahasa));

        $response->assertOk();
        $response->assertViewIs('bahasa.edit');
        $response->assertViewHas('bahasa');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BahasaController::class,
            'update',
            \App\Http\Requests\BahasaUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $bahasa = Bahasa::factory()->create();
        $bahasa = $this->faker->word();

        $response = $this->put(route('bahasa.update', $bahasa), [
            'bahasa' => $bahasa,
        ]);

        $bahasa->refresh();

        $response->assertRedirect(route('bahasa.index'));
        $response->assertSessionHas('bahasa.id', $bahasa->id);

        $this->assertEquals($bahasa, $bahasa->bahasa);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $bahasa = Bahasa::factory()->create();

        $response = $this->delete(route('bahasa.destroy', $bahasa));

        $response->assertRedirect(route('bahasa.index'));

        $this->assertModelMissing($bahasa);
    }
}
