<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Employer;
use App\Models\IndustriType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EmployerController
 */
final class EmployerControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $employers = Employer::factory()->count(3)->create();

        $response = $this->get(route('employer.index'));

        $response->assertOk();
        $response->assertViewIs('employer.index');
        $response->assertViewHas('employers');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('employer.create'));

        $response->assertOk();
        $response->assertViewIs('employer.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployerController::class,
            'store',
            \App\Http\Requests\EmployerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $user = User::factory()->create();
        $nama_perusahaan = $this->faker->word();
        $deskripsi_perusahaan = $this->faker->text();
        $industriType = IndustriType::factory()->create();

        $response = $this->post(route('employer.store'), [
            'user_id' => $user->id,
            'nama_perusahaan' => $nama_perusahaan,
            'deskripsi_perusahaan' => $deskripsi_perusahaan,
            'industriType_id' => $industriType->id,
        ]);

        $employers = Employer::query()
            ->where('user_id', $user->id)
            ->where('nama_perusahaan', $nama_perusahaan)
            ->where('deskripsi_perusahaan', $deskripsi_perusahaan)
            ->where('industriType_id', $industriType->id)
            ->get();
        $this->assertCount(1, $employers);
        $employer = $employers->first();

        $response->assertRedirect(route('employer.index'));
        $response->assertSessionHas('employer.id', $employer->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $employer = Employer::factory()->create();

        $response = $this->get(route('employer.show', $employer));

        $response->assertOk();
        $response->assertViewIs('employer.show');
        $response->assertViewHas('employer');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $employer = Employer::factory()->create();

        $response = $this->get(route('employer.edit', $employer));

        $response->assertOk();
        $response->assertViewIs('employer.edit');
        $response->assertViewHas('employer');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployerController::class,
            'update',
            \App\Http\Requests\EmployerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $employer = Employer::factory()->create();
        $user = User::factory()->create();
        $nama_perusahaan = $this->faker->word();
        $deskripsi_perusahaan = $this->faker->text();
        $industriType = IndustriType::factory()->create();

        $response = $this->put(route('employer.update', $employer), [
            'user_id' => $user->id,
            'nama_perusahaan' => $nama_perusahaan,
            'deskripsi_perusahaan' => $deskripsi_perusahaan,
            'industriType_id' => $industriType->id,
        ]);

        $employer->refresh();

        $response->assertRedirect(route('employer.index'));
        $response->assertSessionHas('employer.id', $employer->id);

        $this->assertEquals($user->id, $employer->user_id);
        $this->assertEquals($nama_perusahaan, $employer->nama_perusahaan);
        $this->assertEquals($deskripsi_perusahaan, $employer->deskripsi_perusahaan);
        $this->assertEquals($industriType->id, $employer->industriType_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $employer = Employer::factory()->create();

        $response = $this->delete(route('employer.destroy', $employer));

        $response->assertRedirect(route('employer.index'));

        $this->assertModelMissing($employer);
    }
}
