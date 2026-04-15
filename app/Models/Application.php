<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;

    protected $table = 'application';

    protected $fillable = [
        'jobseeker_id',
        'job_id',
        'tanggal_apply',
        'status',
    ];

    protected $casts = [
        'id' => 'integer',
        'jobseeker_id' => 'integer',
        'job_id' => 'integer',
        'tanggal_apply' => 'date',
    ];

    public function progress(): HasMany
    {
        return $this->hasMany(Progress::class);
    }

    public function jobseeker(): BelongsTo
    {
        return $this->belongsTo(Jobseeker::class);
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Latest progress entry per step for this application.
     * Keyed by step_id for easy lookup in views.
     */
    public function progressByStep()
    {
        return $this->progress()
            ->get()
            ->groupBy('step_id')
            ->map(fn ($entries) => $entries->sortByDesc('id')->first());
    }

    /**
     * The current (active) step for this application:
     * the first step the jobseeker has not yet passed.
     * Returns null if the application is finished or has no steps.
     */
    public function currentStep()
    {
        $steps = $this->job?->steps()->with('proses')->get() ?? collect();
        if ($steps->isEmpty()) {
            return null;
        }

        $progressMap = $this->progressByStep();

        foreach ($steps as $step) {
            $p = $progressMap->get($step->id);
            if (!$p || !$p->lulus) {
                return $step;
            }
        }

        // All steps passed
        return null;
    }

    public function isFinalized(): bool
    {
        return in_array($this->status, ['accepted', 'rejected'], true);
    }

    /**
     * A step is editable only when it is the current step AND
     * the application has not been finalized yet.
     */
    public function isStepEditable(Step $step): bool
    {
        if ($this->isFinalized()) {
            return false;
        }

        $current = $this->currentStep();
        return $current && $current->id === $step->id;
    }

    /**
     * Derive the application status from current progress entries.
     *   - any step failed  -> rejected
     *   - all steps passed -> accepted
     *   - otherwise        -> pending
     */
    public function syncStatusFromProgress(): void
    {
        $steps = $this->job?->steps ?? collect();
        if ($steps->isEmpty()) {
            return;
        }

        $progressMap = $this->progressByStep();
        $anyFailed = false;
        $allPassed = true;

        foreach ($steps as $step) {
            $p = $progressMap->get($step->id);
            if ($p && !$p->lulus) {
                $anyFailed = true;
                break;
            }
            if (!$p || !$p->lulus) {
                $allPassed = false;
            }
        }

        $newStatus = $anyFailed ? 'rejected' : ($allPassed ? 'accepted' : 'pending');

        if ($this->status !== $newStatus) {
            $this->update(['status' => $newStatus]);
        }
    }
}
