<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Account;
use App\Models\Membership;
use App\Models\NomorRekening;
use App\Models\Pembayaran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PembayaranController
 */
final class PembayaranControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $pembayarans = Pembayaran::factory()->count(3)->create();

        $response = $this->get(route('pembayaran.index'));

        $response->assertOk();
        $response->assertViewIs('pembayaran.index');
        $response->assertViewHas('pembayarans');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('pembayaran.create'));

        $response->assertOk();
        $response->assertViewIs('pembayaran.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PembayaranController::class,
            'store',
            \App\Http\Requests\PembayaranStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $user = User::factory()->create();
        $membership = Membership::factory()->create();
        $tgl_mulai = $this->faker->date();
        $tgl_berakhir = $this->faker->date();
        $nomor_rekening = NomorRekening::factory()->create();
        $account = Account::factory()->create();

        $response = $this->post(route('pembayaran.store'), [
            'user_id' => $user->id,
            'membership_id' => $membership->id,
            'tgl_mulai' => $tgl_mulai,
            'tgl_berakhir' => $tgl_berakhir,
            'nomor_rekening' => $nomor_rekening->id,
            'account_id' => $account->id,
        ]);

        $pembayarans = Pembayaran::query()
            ->where('user_id', $user->id)
            ->where('membership_id', $membership->id)
            ->where('tgl_mulai', $tgl_mulai)
            ->where('tgl_berakhir', $tgl_berakhir)
            ->where('nomor_rekening', $nomor_rekening->id)
            ->where('account_id', $account->id)
            ->get();
        $this->assertCount(1, $pembayarans);
        $pembayaran = $pembayarans->first();

        $response->assertRedirect(route('pembayaran.index'));
        $response->assertSessionHas('pembayaran.id', $pembayaran->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $pembayaran = Pembayaran::factory()->create();

        $response = $this->get(route('pembayaran.show', $pembayaran));

        $response->assertOk();
        $response->assertViewIs('pembayaran.show');
        $response->assertViewHas('pembayaran');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $pembayaran = Pembayaran::factory()->create();

        $response = $this->get(route('pembayaran.edit', $pembayaran));

        $response->assertOk();
        $response->assertViewIs('pembayaran.edit');
        $response->assertViewHas('pembayaran');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PembayaranController::class,
            'update',
            \App\Http\Requests\PembayaranUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $pembayaran = Pembayaran::factory()->create();
        $user = User::factory()->create();
        $membership = Membership::factory()->create();
        $tgl_mulai = $this->faker->date();
        $tgl_berakhir = $this->faker->date();
        $nomor_rekening = NomorRekening::factory()->create();
        $account = Account::factory()->create();

        $response = $this->put(route('pembayaran.update', $pembayaran), [
            'user_id' => $user->id,
            'membership_id' => $membership->id,
            'tgl_mulai' => $tgl_mulai,
            'tgl_berakhir' => $tgl_berakhir,
            'nomor_rekening' => $nomor_rekening->id,
            'account_id' => $account->id,
        ]);

        $pembayaran->refresh();

        $response->assertRedirect(route('pembayaran.index'));
        $response->assertSessionHas('pembayaran.id', $pembayaran->id);

        $this->assertEquals($user->id, $pembayaran->user_id);
        $this->assertEquals($membership->id, $pembayaran->membership_id);
        $this->assertEquals(Carbon::parse($tgl_mulai), $pembayaran->tgl_mulai);
        $this->assertEquals(Carbon::parse($tgl_berakhir), $pembayaran->tgl_berakhir);
        $this->assertEquals($nomor_rekening->id, $pembayaran->nomor_rekening);
        $this->assertEquals($account->id, $pembayaran->account_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $pembayaran = Pembayaran::factory()->create();

        $response = $this->delete(route('pembayaran.destroy', $pembayaran));

        $response->assertRedirect(route('pembayaran.index'));

        $this->assertModelMissing($pembayaran);
    }
}
