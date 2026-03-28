<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Job;
use App\Models\Proses;
use App\Models\Step;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\StepController
 */
final class StepControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $steps = Step::factory()->count(3)->create();

        $response = $this->get(route('step.index'));

        $response->assertOk();
        $response->assertViewIs('step.index');
        $response->assertViewHas('steps');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('step.create'));

        $response->assertOk();
        $response->assertViewIs('step.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StepController::class,
            'store',
            \App\Http\Requests\StepStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $job = Job::factory()->create();
        $proses = Proses::factory()->create();
        $deskripsi = $this->faker->text();

        $response = $this->post(route('step.store'), [
            'job_id' => $job->id,
            'proses_id' => $proses->id,
            'deskripsi' => $deskripsi,
        ]);

        $steps = Step::query()
            ->where('job_id', $job->id)
            ->where('proses_id', $proses->id)
            ->where('deskripsi', $deskripsi)
            ->get();
        $this->assertCount(1, $steps);
        $step = $steps->first();

        $response->assertRedirect(route('step.index'));
        $response->assertSessionHas('step.id', $step->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $step = Step::factory()->create();

        $response = $this->get(route('step.show', $step));

        $response->assertOk();
        $response->assertViewIs('step.show');
        $response->assertViewHas('step');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $step = Step::factory()->create();

        $response = $this->get(route('step.edit', $step));

        $response->assertOk();
        $response->assertViewIs('step.edit');
        $response->assertViewHas('step');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StepController::class,
            'update',
            \App\Http\Requests\StepUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $step = Step::factory()->create();
        $job = Job::factory()->create();
        $proses = Proses::factory()->create();
        $deskripsi = $this->faker->text();

        $response = $this->put(route('step.update', $step), [
            'job_id' => $job->id,
            'proses_id' => $proses->id,
            'deskripsi' => $deskripsi,
        ]);

        $step->refresh();

        $response->assertRedirect(route('step.index'));
        $response->assertSessionHas('step.id', $step->id);

        $this->assertEquals($job->id, $step->job_id);
        $this->assertEquals($proses->id, $step->proses_id);
        $this->assertEquals($deskripsi, $step->deskripsi);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $step = Step::factory()->create();

        $response = $this->delete(route('step.destroy', $step));

        $response->assertRedirect(route('step.index'));

        $this->assertModelMissing($step);
    }
}
