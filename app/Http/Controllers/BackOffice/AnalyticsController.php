<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Application;

class AnalyticsController extends Controller
{
    public function index()
    {
        $applications = Application::with([
            'jobseeker.jobseekerType',
            'job.steps.proses',
            'progress.step.proses',
        ])
        ->whereHas('jobseeker.jobseekerType', fn($q) => $q->where('jobseekerType', 'Unand'))
        ->get();

        $total    = $applications->count();
        $accepted = $applications->where('status', 'accepted')->count();
        $rejected = $applications->where('status', 'rejected')->count();
        $pending  = $applications->where('status', 'pending')->count();
        $passRate = $total > 0 ? round($accepted / $total * 100, 1) : 0;

        $prosesStats = [];

        foreach ($applications as $app) {
            $progressedStepIds = $app->progress->pluck('step_id')->flip();

            foreach ($app->progress as $prog) {
                $proses = $prog->step?->proses;
                if (!$proses) {
                    continue;
                }
                $this->ensureProses($prosesStats, $proses);
                $prosesStats[$proses->id]['total_reached']++;
                if ($prog->lulus) {
                    $prosesStats[$proses->id]['passed']++;
                } else {
                    $prosesStats[$proses->id]['failed']++;
                }
            }

            // For pending apps, identify and tally the current step (first step with no progress record yet)
            if ($app->status === 'pending') {
                $steps = $app->job?->steps ?? collect();
                foreach ($steps->sortBy('urutan') as $step) {
                    if (!$progressedStepIds->has($step->id)) {
                        $proses = $step->proses;
                        if ($proses) {
                            $this->ensureProses($prosesStats, $proses);
                            $prosesStats[$proses->id]['total_reached']++;
                            $prosesStats[$proses->id]['currently_active']++;
                        }
                        break;
                    }
                }
            }
        }

        uasort($prosesStats, fn($a, $b) => $b['failed'] <=> $a['failed']);

        return view('backoffice.analytics.index', compact(
            'total', 'accepted', 'rejected', 'pending', 'passRate', 'prosesStats'
        ));
    }

    private function ensureProses(array &$prosesStats, $proses): void
    {
        if (!isset($prosesStats[$proses->id])) {
            $prosesStats[$proses->id] = [
                'nama'             => $proses->nama_proses,
                'total_reached'    => 0,
                'passed'           => 0,
                'failed'           => 0,
                'currently_active' => 0,
            ];
        }
    }
}
