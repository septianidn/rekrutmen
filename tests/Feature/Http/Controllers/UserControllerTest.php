<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserController
 */
final class UserControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $users = User::factory()->count(3)->create();

        $response = $this->get(route('user.index'));

        $response->assertOk();
        $response->assertViewIs('user.index');
        $response->assertViewHas('users');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('user.create'));

        $response->assertOk();
        $response->assertViewIs('user.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserController::class,
            'store',
            \App\Http\Requests\UserStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $password = $this->faker->password();
        $email = $this->faker->safeEmail();
        $user_type = $this->faker->word();
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('user.store'), [
            'password' => $password,
            'email' => $email,
            'user_type' => $user_type,
            'status' => $status,
        ]);

        $users = User::query()
            ->where('password', $password)
            ->where('email', $email)
            ->where('user_type', $user_type)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $users);
        $user = $users->first();

        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('user.id', $user->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('user.show', $user));

        $response->assertOk();
        $response->assertViewIs('user.show');
        $response->assertViewHas('user');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('user.edit', $user));

        $response->assertOk();
        $response->assertViewIs('user.edit');
        $response->assertViewHas('user');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserController::class,
            'update',
            \App\Http\Requests\UserUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $user = User::factory()->create();
        $password = $this->faker->password();
        $email = $this->faker->safeEmail();
        $user_type = $this->faker->word();
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->put(route('user.update', $user), [
            'password' => $password,
            'email' => $email,
            'user_type' => $user_type,
            'status' => $status,
        ]);

        $user->refresh();

        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('user.id', $user->id);

        $this->assertEquals($password, $user->password);
        $this->assertEquals($email, $user->email);
        $this->assertEquals($user_type, $user->user_type);
        $this->assertEquals($status, $user->status);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $user = User::factory()->create();

        $response = $this->delete(route('user.destroy', $user));

        $response->assertRedirect(route('user.index'));

        $this->assertModelMissing($user);
    }
}
