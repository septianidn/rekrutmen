<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Employer;
use App\Models\IndustriType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\IndustriTypeController
 */
final class IndustriTypeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $industriTypes = IndustriType::factory()->count(3)->create();

        $response = $this->get(route('industri-type.index'));

        $response->assertOk();
        $response->assertViewIs('industriType.index');
        $response->assertViewHas('industriTypes');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('industri-type.create'));

        $response->assertOk();
        $response->assertViewIs('industriType.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\IndustriTypeController::class,
            'store',
            \App\Http\Requests\IndustriTypeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nama_industri = $this->faker->word();
        $employer = Employer::factory()->create();

        $response = $this->post(route('industri-type.store'), [
            'nama_industri' => $nama_industri,
            'employer_id' => $employer->id,
        ]);

        $industriTypes = IndustriType::query()
            ->where('nama_industri', $nama_industri)
            ->where('employer_id', $employer->id)
            ->get();
        $this->assertCount(1, $industriTypes);
        $industriType = $industriTypes->first();

        $response->assertRedirect(route('industri-type.index'));
        $response->assertSessionHas('industriType.id', $industriType->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $industriType = IndustriType::factory()->create();

        $response = $this->get(route('industri-type.show', $industriType));

        $response->assertOk();
        $response->assertViewIs('industriType.show');
        $response->assertViewHas('industriType');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $industriType = IndustriType::factory()->create();

        $response = $this->get(route('industri-type.edit', $industriType));

        $response->assertOk();
        $response->assertViewIs('industriType.edit');
        $response->assertViewHas('industriType');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\IndustriTypeController::class,
            'update',
            \App\Http\Requests\IndustriTypeUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $industriType = IndustriType::factory()->create();
        $nama_industri = $this->faker->word();
        $employer = Employer::factory()->create();

        $response = $this->put(route('industri-type.update', $industriType), [
            'nama_industri' => $nama_industri,
            'employer_id' => $employer->id,
        ]);

        $industriType->refresh();

        $response->assertRedirect(route('industri-type.index'));
        $response->assertSessionHas('industriType.id', $industriType->id);

        $this->assertEquals($nama_industri, $industriType->nama_industri);
        $this->assertEquals($employer->id, $industriType->employer_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $industriType = IndustriType::factory()->create();

        $response = $this->delete(route('industri-type.destroy', $industriType));

        $response->assertRedirect(route('industri-type.index'));

        $this->assertModelMissing($industriType);
    }
}
