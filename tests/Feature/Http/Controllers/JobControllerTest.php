<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Employer;
use App\Models\Job;
use App\Models\Posisi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\JobController
 */
final class JobControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $jobs = Job::factory()->count(3)->create();

        $response = $this->get(route('job.index'));

        $response->assertOk();
        $response->assertViewIs('job.index');
        $response->assertViewHas('jobs');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('job.create'));

        $response->assertOk();
        $response->assertViewIs('job.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\JobController::class,
            'store',
            \App\Http\Requests\JobStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $employer = Employer::factory()->create();
        $nama_pekerjaan = $this->faker->word();
        $kuota = $this->faker->numberBetween(-10000, 10000);
        $posisi = Posisi::factory()->create();

        $response = $this->post(route('job.store'), [
            'employer_id' => $employer->id,
            'nama_pekerjaan' => $nama_pekerjaan,
            'kuota' => $kuota,
            'posisi_id' => $posisi->id,
        ]);

        $jobs = Job::query()
            ->where('employer_id', $employer->id)
            ->where('nama_pekerjaan', $nama_pekerjaan)
            ->where('kuota', $kuota)
            ->where('posisi_id', $posisi->id)
            ->get();
        $this->assertCount(1, $jobs);
        $job = $jobs->first();

        $response->assertRedirect(route('job.index'));
        $response->assertSessionHas('job.id', $job->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $job = Job::factory()->create();

        $response = $this->get(route('job.show', $job));

        $response->assertOk();
        $response->assertViewIs('job.show');
        $response->assertViewHas('job');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $job = Job::factory()->create();

        $response = $this->get(route('job.edit', $job));

        $response->assertOk();
        $response->assertViewIs('job.edit');
        $response->assertViewHas('job');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\JobController::class,
            'update',
            \App\Http\Requests\JobUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $job = Job::factory()->create();
        $employer = Employer::factory()->create();
        $nama_pekerjaan = $this->faker->word();
        $kuota = $this->faker->numberBetween(-10000, 10000);
        $posisi = Posisi::factory()->create();

        $response = $this->put(route('job.update', $job), [
            'employer_id' => $employer->id,
            'nama_pekerjaan' => $nama_pekerjaan,
            'kuota' => $kuota,
            'posisi_id' => $posisi->id,
        ]);

        $job->refresh();

        $response->assertRedirect(route('job.index'));
        $response->assertSessionHas('job.id', $job->id);

        $this->assertEquals($employer->id, $job->employer_id);
        $this->assertEquals($nama_pekerjaan, $job->nama_pekerjaan);
        $this->assertEquals($kuota, $job->kuota);
        $this->assertEquals($posisi->id, $job->posisi_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $job = Job::factory()->create();

        $response = $this->delete(route('job.destroy', $job));

        $response->assertRedirect(route('job.index'));

        $this->assertModelMissing($job);
    }
}
