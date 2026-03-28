<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Application;
use App\Models\Jobseeker;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ApplicationController
 */
final class ApplicationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $applications = Application::factory()->count(3)->create();

        $response = $this->get(route('application.index'));

        $response->assertOk();
        $response->assertViewIs('application.index');
        $response->assertViewHas('applications');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('application.create'));

        $response->assertOk();
        $response->assertViewIs('application.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ApplicationController::class,
            'store',
            \App\Http\Requests\ApplicationStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $jobseeker = Jobseeker::factory()->create();
        $tanggal_apply = $this->faker->date();

        $response = $this->post(route('application.store'), [
            'jobseeker_id' => $jobseeker->id,
            'tanggal_apply' => $tanggal_apply,
        ]);

        $applications = Application::query()
            ->where('jobseeker_id', $jobseeker->id)
            ->where('tanggal_apply', $tanggal_apply)
            ->get();
        $this->assertCount(1, $applications);
        $application = $applications->first();

        $response->assertRedirect(route('application.index'));
        $response->assertSessionHas('application.id', $application->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $application = Application::factory()->create();

        $response = $this->get(route('application.show', $application));

        $response->assertOk();
        $response->assertViewIs('application.show');
        $response->assertViewHas('application');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $application = Application::factory()->create();

        $response = $this->get(route('application.edit', $application));

        $response->assertOk();
        $response->assertViewIs('application.edit');
        $response->assertViewHas('application');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ApplicationController::class,
            'update',
            \App\Http\Requests\ApplicationUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $application = Application::factory()->create();
        $jobseeker = Jobseeker::factory()->create();
        $tanggal_apply = $this->faker->date();

        $response = $this->put(route('application.update', $application), [
            'jobseeker_id' => $jobseeker->id,
            'tanggal_apply' => $tanggal_apply,
        ]);

        $application->refresh();

        $response->assertRedirect(route('application.index'));
        $response->assertSessionHas('application.id', $application->id);

        $this->assertEquals($jobseeker->id, $application->jobseeker_id);
        $this->assertEquals(Carbon::parse($tanggal_apply), $application->tanggal_apply);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $application = Application::factory()->create();

        $response = $this->delete(route('application.destroy', $application));

        $response->assertRedirect(route('application.index'));

        $this->assertModelMissing($application);
    }
}
