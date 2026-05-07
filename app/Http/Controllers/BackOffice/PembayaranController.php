<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $kategori = $request->query('kategori');

        $query = Pembayaran::with(['employer.user', 'membership'])->latest();

        if (in_array($status, ['pending', 'lunas', 'gagal', 'expired'], true)) {
            $query->where('status', $status);
        }
        if (in_array($kategori, ['membership', 'event'], true)) {
            $query->where('kategori', $kategori);
        }

        $pembayarans = $query->paginate(20)->withQueryString();

        $counts = [
            'total'   => Pembayaran::count(),
            'pending' => Pembayaran::where('status', 'pending')->count(),
            'lunas'   => Pembayaran::where('status', 'lunas')->count(),
            'gagal'   => Pembayaran::where('status', 'gagal')->count(),
        ];

        return view('backoffice.pembayaran.index', compact('pembayarans', 'status', 'kategori', 'counts'));
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['employer.user', 'membership']);
        return view('backoffice.pembayaran.show', compact('pembayaran'));
    }
}
