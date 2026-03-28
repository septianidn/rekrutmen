<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Membership;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MembershipController
 */
final class MembershipControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $memberships = Membership::factory()->count(3)->create();

        $response = $this->get(route('membership.index'));

        $response->assertOk();
        $response->assertViewIs('membership.index');
        $response->assertViewHas('memberships');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('membership.create'));

        $response->assertOk();
        $response->assertViewIs('membership.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MembershipController::class,
            'store',
            \App\Http\Requests\MembershipStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nama_membership = $this->faker->word();
        $durasi = $this->faker->word();
        $harga = $this->faker->word();

        $response = $this->post(route('membership.store'), [
            'nama_membership' => $nama_membership,
            'durasi' => $durasi,
            'harga' => $harga,
        ]);

        $memberships = Membership::query()
            ->where('nama_membership', $nama_membership)
            ->where('durasi', $durasi)
            ->where('harga', $harga)
            ->get();
        $this->assertCount(1, $memberships);
        $membership = $memberships->first();

        $response->assertRedirect(route('membership.index'));
        $response->assertSessionHas('membership.id', $membership->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $membership = Membership::factory()->create();

        $response = $this->get(route('membership.show', $membership));

        $response->assertOk();
        $response->assertViewIs('membership.show');
        $response->assertViewHas('membership');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $membership = Membership::factory()->create();

        $response = $this->get(route('membership.edit', $membership));

        $response->assertOk();
        $response->assertViewIs('membership.edit');
        $response->assertViewHas('membership');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MembershipController::class,
            'update',
            \App\Http\Requests\MembershipUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $membership = Membership::factory()->create();
        $nama_membership = $this->faker->word();
        $durasi = $this->faker->word();
        $harga = $this->faker->word();

        $response = $this->put(route('membership.update', $membership), [
            'nama_membership' => $nama_membership,
            'durasi' => $durasi,
            'harga' => $harga,
        ]);

        $membership->refresh();

        $response->assertRedirect(route('membership.index'));
        $response->assertSessionHas('membership.id', $membership->id);

        $this->assertEquals($nama_membership, $membership->nama_membership);
        $this->assertEquals($durasi, $membership->durasi);
        $this->assertEquals($harga, $membership->harga);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $membership = Membership::factory()->create();

        $response = $this->delete(route('membership.destroy', $membership));

        $response->assertRedirect(route('membership.index'));

        $this->assertModelMissing($membership);
    }
}
