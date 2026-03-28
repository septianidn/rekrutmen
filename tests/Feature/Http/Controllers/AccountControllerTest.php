<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
final class AccountControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $accounts = Account::factory()->count(3)->create();

        $response = $this->get(route('account.index'));

        $response->assertOk();
        $response->assertViewIs('account.index');
        $response->assertViewHas('accounts');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('account.create'));

        $response->assertOk();
        $response->assertViewIs('account.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccountController::class,
            'store',
            \App\Http\Requests\AccountStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nama_bank = $this->faker->word();
        $atas_nama = $this->faker->word();

        $response = $this->post(route('account.store'), [
            'nama_bank' => $nama_bank,
            'atas_nama' => $atas_nama,
        ]);

        $accounts = Account::query()
            ->where('nama_bank', $nama_bank)
            ->where('atas_nama', $atas_nama)
            ->get();
        $this->assertCount(1, $accounts);
        $account = $accounts->first();

        $response->assertRedirect(route('account.index'));
        $response->assertSessionHas('account.id', $account->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $account = Account::factory()->create();

        $response = $this->get(route('account.show', $account));

        $response->assertOk();
        $response->assertViewIs('account.show');
        $response->assertViewHas('account');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $account = Account::factory()->create();

        $response = $this->get(route('account.edit', $account));

        $response->assertOk();
        $response->assertViewIs('account.edit');
        $response->assertViewHas('account');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccountController::class,
            'update',
            \App\Http\Requests\AccountUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $account = Account::factory()->create();
        $nama_bank = $this->faker->word();
        $atas_nama = $this->faker->word();

        $response = $this->put(route('account.update', $account), [
            'nama_bank' => $nama_bank,
            'atas_nama' => $atas_nama,
        ]);

        $account->refresh();

        $response->assertRedirect(route('account.index'));
        $response->assertSessionHas('account.id', $account->id);

        $this->assertEquals($nama_bank, $account->nama_bank);
        $this->assertEquals($atas_nama, $account->atas_nama);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $account = Account::factory()->create();

        $response = $this->delete(route('account.destroy', $account));

        $response->assertRedirect(route('account.index'));

        $this->assertModelMissing($account);
    }
}
