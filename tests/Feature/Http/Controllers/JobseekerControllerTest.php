<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Jobseeker;
use App\Models\JobseekerType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\JobseekerController
 */
final class JobseekerControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $jobseekers = Jobseeker::factory()->count(3)->create();

        $response = $this->get(route('jobseeker.index'));

        $response->assertOk();
        $response->assertViewIs('jobseeker.index');
        $response->assertViewHas('jobseekers');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('jobseeker.create'));

        $response->assertOk();
        $response->assertViewIs('jobseeker.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\JobseekerController::class,
            'store',
            \App\Http\Requests\JobseekerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $user = User::factory()->create();
        $first_name = $this->faker->firstName();
        $last_name = $this->faker->lastName();
        $jenis_kelamin = $this->faker->word();
        $ttl = $this->faker->date();
        $jobseeker = Jobseeker::factory()->create();
        $jobseeker_type = JobseekerType::factory()->create();

        $response = $this->post(route('jobseeker.store'), [
            'user_id' => $user->id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'jenis_kelamin' => $jenis_kelamin,
            'ttl' => $ttl,
            'jobseeker_id_type' => $jobseeker->id,
            'jobseeker_type_id' => $jobseeker_type->id,
        ]);

        $jobseekers = Jobseeker::query()
            ->where('user_id', $user->id)
            ->where('first_name', $first_name)
            ->where('last_name', $last_name)
            ->where('jenis_kelamin', $jenis_kelamin)
            ->where('ttl', $ttl)
            ->where('jobseeker_id_type', $jobseeker->id)
            ->where('jobseeker_type_id', $jobseeker_type->id)
            ->get();
        $this->assertCount(1, $jobseekers);
        $jobseeker = $jobseekers->first();

        $response->assertRedirect(route('jobseeker.index'));
        $response->assertSessionHas('jobseeker.id', $jobseeker->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $jobseeker = Jobseeker::factory()->create();

        $response = $this->get(route('jobseeker.show', $jobseeker));

        $response->assertOk();
        $response->assertViewIs('jobseeker.show');
        $response->assertViewHas('jobseeker');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $jobseeker = Jobseeker::factory()->create();

        $response = $this->get(route('jobseeker.edit', $jobseeker));

        $response->assertOk();
        $response->assertViewIs('jobseeker.edit');
        $response->assertViewHas('jobseeker');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\JobseekerController::class,
            'update',
            \App\Http\Requests\JobseekerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $jobseeker = Jobseeker::factory()->create();
        $user = User::factory()->create();
        $first_name = $this->faker->firstName();
        $last_name = $this->faker->lastName();
        $jenis_kelamin = $this->faker->word();
        $ttl = $this->faker->date();
        $jobseeker_type = JobseekerType::factory()->create();

        $response = $this->put(route('jobseeker.update', $jobseeker), [
            'user_id' => $user->id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'jenis_kelamin' => $jenis_kelamin,
            'ttl' => $ttl,
            'jobseeker_id_type' => $jobseeker->id,
            'jobseeker_type_id' => $jobseeker_type->id,
        ]);

        $jobseeker->refresh();

        $response->assertRedirect(route('jobseeker.index'));
        $response->assertSessionHas('jobseeker.id', $jobseeker->id);

        $this->assertEquals($user->id, $jobseeker->user_id);
        $this->assertEquals($first_name, $jobseeker->first_name);
        $this->assertEquals($last_name, $jobseeker->last_name);
        $this->assertEquals($jenis_kelamin, $jobseeker->jenis_kelamin);
        $this->assertEquals(Carbon::parse($ttl), $jobseeker->ttl);
        $this->assertEquals($jobseeker->id, $jobseeker->jobseeker_id_type);
        $this->assertEquals($jobseeker_type->id, $jobseeker->jobseeker_type_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $jobseeker = Jobseeker::factory()->create();

        $response = $this->delete(route('jobseeker.destroy', $jobseeker));

        $response->assertRedirect(route('jobseeker.index'));

        $this->assertModelMissing($jobseeker);
    }
}
