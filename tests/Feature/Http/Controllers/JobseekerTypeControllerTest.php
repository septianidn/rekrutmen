<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\JobseekerType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\JobseekerTypeController
 */
final class JobseekerTypeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $jobseekerTypes = JobseekerType::factory()->count(3)->create();

        $response = $this->get(route('jobseeker-type.index'));

        $response->assertOk();
        $response->assertViewIs('jobseekerType.index');
        $response->assertViewHas('jobseekerTypes');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('jobseeker-type.create'));

        $response->assertOk();
        $response->assertViewIs('jobseekerType.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\JobseekerTypeController::class,
            'store',
            \App\Http\Requests\JobseekerTypeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $jobseekerType = $this->faker->word();

        $response = $this->post(route('jobseeker-type.store'), [
            'jobseekerType' => $jobseekerType,
        ]);

        $jobseekerTypes = JobseekerType::query()
            ->where('jobseekerType', $jobseekerType)
            ->get();
        $this->assertCount(1, $jobseekerTypes);
        $jobseekerType = $jobseekerTypes->first();

        $response->assertRedirect(route('jobseeker-type.index'));
        $response->assertSessionHas('jobseekerType.id', $jobseekerType->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $jobseekerType = JobseekerType::factory()->create();

        $response = $this->get(route('jobseeker-type.show', $jobseekerType));

        $response->assertOk();
        $response->assertViewIs('jobseekerType.show');
        $response->assertViewHas('jobseekerType');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $jobseekerType = JobseekerType::factory()->create();

        $response = $this->get(route('jobseeker-type.edit', $jobseekerType));

        $response->assertOk();
        $response->assertViewIs('jobseekerType.edit');
        $response->assertViewHas('jobseekerType');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\JobseekerTypeController::class,
            'update',
            \App\Http\Requests\JobseekerTypeUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $jobseekerType = JobseekerType::factory()->create();
        $jobseekerType = $this->faker->word();

        $response = $this->put(route('jobseeker-type.update', $jobseekerType), [
            'jobseekerType' => $jobseekerType,
        ]);

        $jobseekerType->refresh();

        $response->assertRedirect(route('jobseeker-type.index'));
        $response->assertSessionHas('jobseekerType.id', $jobseekerType->id);

        $this->assertEquals($jobseekerType, $jobseekerType->jobseekerType);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $jobseekerType = JobseekerType::factory()->create();

        $response = $this->delete(route('jobseeker-type.destroy', $jobseekerType));

        $response->assertRedirect(route('jobseeker-type.index'));

        $this->assertModelMissing($jobseekerType);
    }
}
