<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Application;
use App\Models\Progress;
use App\Models\Step;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProgressController
 */
final class ProgressControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $progress = Progress::factory()->count(3)->create();

        $response = $this->get(route('progress.index'));

        $response->assertOk();
        $response->assertViewIs('progress.index');
        $response->assertViewHas('progress');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('progress.create'));

        $response->assertOk();
        $response->assertViewIs('progress.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProgressController::class,
            'store',
            \App\Http\Requests\ProgressStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $application = Application::factory()->create();
        $step = Step::factory()->create();
        $catatan = $this->faker->text();
        $lulus = $this->faker->boolean();

        $response = $this->post(route('progress.store'), [
            'application_id' => $application->id,
            'step_id' => $step->id,
            'catatan' => $catatan,
            'lulus' => $lulus,
        ]);

        $progress = Progress::query()
            ->where('application_id', $application->id)
            ->where('step_id', $step->id)
            ->where('catatan', $catatan)
            ->where('lulus', $lulus)
            ->get();
        $this->assertCount(1, $progress);
        $progress = $progress->first();

        $response->assertRedirect(route('progress.index'));
        $response->assertSessionHas('progress.id', $progress->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $progress = Progress::factory()->create();

        $response = $this->get(route('progress.show', $progress));

        $response->assertOk();
        $response->assertViewIs('progress.show');
        $response->assertViewHas('progress');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $progress = Progress::factory()->create();

        $response = $this->get(route('progress.edit', $progress));

        $response->assertOk();
        $response->assertViewIs('progress.edit');
        $response->assertViewHas('progress');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProgressController::class,
            'update',
            \App\Http\Requests\ProgressUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $progress = Progress::factory()->create();
        $application = Application::factory()->create();
        $step = Step::factory()->create();
        $catatan = $this->faker->text();
        $lulus = $this->faker->boolean();

        $response = $this->put(route('progress.update', $progress), [
            'application_id' => $application->id,
            'step_id' => $step->id,
            'catatan' => $catatan,
            'lulus' => $lulus,
        ]);

        $progress->refresh();

        $response->assertRedirect(route('progress.index'));
        $response->assertSessionHas('progress.id', $progress->id);

        $this->assertEquals($application->id, $progress->application_id);
        $this->assertEquals($step->id, $progress->step_id);
        $this->assertEquals($catatan, $progress->catatan);
        $this->assertEquals($lulus, $progress->lulus);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $progress = Progress::factory()->create();

        $response = $this->delete(route('progress.destroy', $progress));

        $response->assertRedirect(route('progress.index'));

        $this->assertModelMissing($progress);
    }
}
