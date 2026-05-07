<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::withCount('pembayarans')
            ->orderBy('harga')
            ->paginate(20);

        return view('backoffice.membership.index', compact('memberships'));
    }

    public function create()
    {
        return view('backoffice.membership.form', [
            'membership' => new Membership(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        Membership::create($data);

        return redirect()->route('backoffice.membership.index')
            ->with('success', 'Paket membership berhasil ditambahkan.');
    }

    public function edit(Membership $membership)
    {
        return view('backoffice.membership.form', [
            'membership' => $membership,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Membership $membership)
    {
        $data = $this->validatedData($request);
        $membership->update($data);

        return redirect()->route('backoffice.membership.index')
            ->with('success', 'Paket membership berhasil diperbarui.');
    }

    public function destroy(Membership $membership)
    {
        if ($membership->pembayarans()->exists()) {
            return redirect()->route('backoffice.membership.index')
                ->with('error', 'Paket ini sudah memiliki riwayat pembayaran dan tidak dapat dihapus.');
        }

        $membership->delete();

        return redirect()->route('backoffice.membership.index')
            ->with('success', 'Paket membership dihapus.');
    }

    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'nama_membership'  => 'required|string|max:50',
            'harga'            => 'required|numeric|min:0',
            'durasi_hari'      => 'required|integer|min:1',
            'can_post_job'     => 'sometimes|boolean',
            'can_post_article' => 'sometimes|boolean',
            'deskripsi'        => 'nullable|string|max:1000',
        ]) + [
            'can_post_job'     => $request->boolean('can_post_job'),
            'can_post_article' => $request->boolean('can_post_article'),
        ];
    }
}
