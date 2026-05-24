<?php

namespace App\Console\Commands;

use App\Models\Pembayaran;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class ExpireMemberships extends Command
{
    protected $signature = 'membership:expire {--dry-run : List which rows would be expired without writing changes}';

    protected $description = 'Mark membership payments whose tgl_berakhir is past as expired, and notify employers who lose access.';

    public function handle(): int
    {
        $today = now()->toDateString();
        $dryRun = (bool) $this->option('dry-run');

        $candidates = Pembayaran::with('employer.user', 'membership')
            ->where('kategori', Pembayaran::KATEGORI_MEMBERSHIP)
            ->where('status', Pembayaran::STATUS_LUNAS)
            ->whereNotNull('tgl_berakhir')
            ->whereDate('tgl_berakhir', '<', $today)
            ->get();

        if ($candidates->isEmpty()) {
            $this->info('No memberships to expire.');
            return self::SUCCESS;
        }

        $this->info(($dryRun ? '[DRY RUN] ' : '') . 'Found ' . $candidates->count() . ' membership(s) past tgl_berakhir.');

        $affectedEmployerIds = [];
        foreach ($candidates as $pembayaran) {
            $employerName = $pembayaran->employer->nama_perusahaan ?? 'unknown';
            $tierName = $pembayaran->membership->nama_membership ?? 'unknown tier';
            $expiredOn = $pembayaran->tgl_berakhir?->format('Y-m-d');

            $this->line(" - #{$pembayaran->id} | {$employerName} | {$tierName} | expired {$expiredOn}");

            if (!$dryRun) {
                $pembayaran->update(['status' => Pembayaran::STATUS_EXPIRED]);
                $affectedEmployerIds[$pembayaran->employer_id] = true;
            }
        }

        if ($dryRun) {
            $this->info('[DRY RUN] No changes written.');
            return self::SUCCESS;
        }

        // For each affected employer, check whether they still have any active
        // membership; if not, notify them they've lost access.
        $notifiedCount = 0;
        foreach (array_keys($affectedEmployerIds) as $employerId) {
            $employer = $candidates->firstWhere('employer_id', $employerId)?->employer;
            if (!$employer) {
                continue;
            }

            $stillActive = $employer->pembayarans()->activeMembership()->exists();
            if ($stillActive) {
                continue;
            }

            if ($employer->hasActiveContract()) {
                continue;
            }

            if ($employer->user_id) {
                NotificationService::send(
                    $employer->user_id,
                    'membership_expired',
                    'Membership Berakhir',
                    'Membership Anda telah berakhir dan akses posting lowongan/artikel dinonaktifkan. Perpanjang kapan saja melalui menu Membership.',
                    route('employer.membership.index'),
                );
                $notifiedCount++;
            }
        }

        $this->info('Expired ' . $candidates->count() . ' membership(s). Notified ' . $notifiedCount . ' employer(s) of access loss.');

        return self::SUCCESS;
    }
}
